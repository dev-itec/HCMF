<?php

namespace App\Http\Controllers;

use App\Mail\EstadoDenunciaActualizado;
use App\Models\AnswerStatusHistory;
use Illuminate\Http\Request;
use App\Models\Answer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use MailerSend\Helpers\Builder\Variable;
use MailerSend\Helpers\Builder\Personalization;
use MailerSend\LaravelDriver\MailerSendTrait;
use App\Mail\DenunciaRecibida;
use Carbon\Carbon;

class DenunciaController extends Controller
{
    public function create()
    {
        // Devuelve la vista del formulario de denuncia
        return view('denuncia.create');
    }

    public function store(Request $request)
    {
        // Validar los datos del formulario
        $validated = $request->validate([
            'nombre_completo' => 'required|string|max:255',
            'correo_electronico' => 'nullable|email',
            'relacion' => 'required|string',
            'tipo_denuncia' => 'nullable|array',
            'detalles_incidente' => 'nullable|string',
            'fecha_exacta' => 'nullable|date',
            'fecha_aproximada' => 'nullable|date',
            'hora_incidente' => 'nullable|date_format:H:i',
            'lugar_incidente' => 'nullable|string',
            'descripcion_caso' => 'nullable|string',
            'personas_involucradas' => 'nullable|string',
            'testigos' => 'nullable|string',
            'como_se_entero' => 'nullable|string',
            'como_se_entero_otro' => 'nullable|string',
            'impacto_empresa' => 'nullable|array',
            'impacto_empresa_otro' => 'nullable|string',
            'impacto_personal' => 'nullable|array',
            'impacto_personal_otro' => 'nullable|string',
            'accion_esperada' => 'nullable|array',
            'accion_esperada_otra' => 'nullable|string',
            'evidencia' => 'nullable|array',
            'evidencia.*' => 'file|mimes:jpeg,png,pdf,doc,docx|max:10240', // Validación de archivos
        ]);

        // Generar un identificador y clave únicos
        $identificador = strtoupper(bin2hex(random_bytes(8))); // Genera un código hexadecimal de 12 dígitos
        $clave = bin2hex(random_bytes(3)); // Genera un código hexadecimal de 6 dígitos

        // Variable para almacenar las rutas de evidencia
        $evidenciaPaths = [];

        // Verificar si hay archivos subidos
        if ($request->hasFile('evidencia')) {
            foreach ($request->file('evidencia') as $file) {
                // Generar el nombre del archivo con formato identificador_hhmmss
                $timestamp = now()->format('His');
                $filename = "{$identificador}_{$timestamp}." . $file->getClientOriginalExtension();

                // Obtener la carpeta del tenant actual (reemplaza 'tenant_folder' con tu lógica para obtener el tenant actual)
                $tenantFolder = tenant()->id ?? 'default_tenant';

                // Guardar el archivo en storage/app/tenants/{tenant}/evidencias
                $path = $file->storeAs("tenants/{$tenantFolder}/evidencias", $filename, 'public');

                // Agregar la ruta al array
                $evidenciaPaths[] = $path;
            }
        }

        // Guardar los datos en la base de datos
        Answer::create([
            'identificador' => $identificador,
            'clave' => $clave,
            'nombre_completo' => $request->input('nombre_completo'),
            'rut' => $request->input('rut'),
            'genero' => $request->input('genero'),
            'cargo' => $request->input('cargo'),
            'correo_electronico' => $request->input('correo_electronico'),
            'relacion' => $request->input('relacion'),
            'tipo_denuncia' => $request->input('tipo_denuncia'),
            'detalles_incidente' => $request->input('detalles_incidente'),
            'fecha_exacta' => $request->input('fecha_exacta'),
            'fecha_aproximada' => $request->input('fecha_aproximada'),
            'hora_incidente' => $request->input('hora_incidente'),
            'lugar_incidente' => $request->input('lugar_incidente'),
            'descripcion_caso' => $request->input('descripcion_caso'),
            'personas_involucradas' => $request->input('personas_involucradas'),
            'testigos' => $request->input('testigos'),
            'como_se_entero' => $request->input('como_se_entero'),
            'como_se_entero_otro' => $request->input('como_se_entero_otro'),
            'impacto_empresa' => $request->input('impacto_empresa'),
            'impacto_empresa_otro' => $request->input('impacto_empresa_otro'),
            'impacto_personal' => $request->input('impacto_personal'),
            'impacto_personal_otro' => $request->input('impacto_personal_otro'),
            'accion_esperada' => $request->input('accion_esperada'),
            'accion_esperada_otra' => $request->input('accion_esperada_otra'),
            'evidencia' => json_encode($evidenciaPaths), // Guardar las rutas de evidencia como JSON
        ]);

        // Obtener fecha y hora del navegador (con la zona horaria del servidor)
        $fecha = Carbon::now()->format('d/m/Y');
        $hora = Carbon::now()->format('H:i:s');

        // Enviar correo al denunciante
        // Enviar correo al denunciante
        Mail::to($request->input('correo_electronico'))->send(new DenunciaRecibida(
            $request->input('nombre_completo'),
            $fecha,
            $hora,
            implode(', ', $request->input('tipo_denuncia', [])),
            $identificador,
            $clave
        ));

        // Redirigir a la vista de completado con los datos de identificador y clave
        return redirect()->route('denuncia.completado', ['identificador' => $identificador, 'clave' => $clave])
            ->with('success', '¡Denuncia enviada con éxito!');
    }


    public function completado(Request $request)
    {
        $identificador = $request->input('identificador');
        $clave = $request->input('clave');

        // Pasar los valores a la vista
        return view('denuncia.completado', compact('identificador', 'clave'));
    }

    public function checkStatus(Request $request)
    {
        $numero = $request->input('numero');
        $clave = $request->input('clave');

        // Buscar en la base de datos la denuncia por identificador y clave
        $denuncia = Answer::where('identificador', $numero)
            ->where('clave', $clave)
            ->first();

        if (!$denuncia) {
            return redirect()->back()->withErrors('No se encontró ninguna denuncia con ese identificador y clave.');
        }
        debugbar()->info(get_defined_vars());

        // Mostrar los detalles de la denuncia encontrada
        return view('status.index', compact('denuncia'));
    }

    public function updateStatus(Request $request, $id)
    {
        // Validar el nuevo estado
        $request->validate([
            'status' => 'required|string',
        ]);

        // Buscar la denuncia
        $denuncia = Answer::findOrFail($id);

        // Registrar el cambio de estado
        AnswerStatusHistory::create([
            'answer_id' => $denuncia->id,
            'old_status' => $denuncia->status, // Estado actual antes del cambio
            'new_status' => $request->status,  // El nuevo estado
            'changed_by' => Auth::id() ?? null, // ID del usuario que cambió el estado, si está autenticado
        ]);

        // Actualizar el estado de la denuncia
        $denuncia->update([
            'status' => $request->status,
        ]);

        // Enviar correo de notificación sobre el cambio de estado
        // Cambia $newStatus a $request->status
        Mail::to($denuncia->correo_electronico)->send(new EstadoDenunciaActualizado($denuncia, $request->status));

        return response()->json(['success' => true]);
    }

    public function show($id)
    {
        $denuncia = Answer::findOrFail($id);
        $historial = AnswerStatusHistory::where('answer_id', $id)->orderBy('created_at', 'desc')->get();

        return view('answers.show', compact('denuncia', 'historial'));
    }


}
