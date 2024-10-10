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
use App\Models\Tenant;
use Carbon\Carbon;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;



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
            'evidencia.*' => 'file|max:100000',
        ]);

        // Generar un identificador y clave únicos
        $identificador = strtoupper(bin2hex(random_bytes(8))); // Genera un código hexadecimal de 12 dígitos
        $clave = bin2hex(random_bytes(3)); // Genera un código hexadecimal de 6 dígitos

        // Asignar responsable aleatorio
        $responsable = User::inRandomOrder()->first(); // Selecciona un usuario aleatoriamente de la tabla users

        $evidenciaPaths = [];
        if ($request->hasFile('evidencia')) {
            foreach ($request->file('evidencia') as $file) {
                $timestamp = now()->format('His');
                $uniqueId = uniqid(); // Genera un ID único basado en el tiempo actual
                $filename = "{$identificador}_{$timestamp}_{$uniqueId}." . $file->getClientOriginalExtension();
                $destinationPath = storage_path("/evidencias");

                if (!File::exists($destinationPath)) {
                    File::makeDirectory($destinationPath, 0755, true);
                }

                $file->move($destinationPath, $filename);

                $evidenciaPaths[] = "{$filename}";
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
            'responsable' => $responsable->email, // Almacenar el email del usuario responsable
        ]);

        // Obtener fecha y hora del navegador (con la zona horaria del servidor)
        $fecha = Carbon::now()->format('d/m/Y');
        $hora = Carbon::now()->format('H:i:s');

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


    /*public function store(Request $request)
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
            'evidencia.*' => 'nullable|file|mimes:jpg,jpeg,png,pdf,mp3,mp4,zip|max:10240',
        ]);

        DB::beginTransaction(); // Inicia una transacción

        try {
            // Generar un identificador y clave únicos
            $identificador = strtoupper(bin2hex(random_bytes(8))); // Genera un código hexadecimal de 12 dígitos
            $clave = bin2hex(random_bytes(3)); // Genera un código hexadecimal de 6 dígitos

            // Manejar los archivos de evidencia
            $evidenciaPaths = [];
            if ($request->hasFile('evidencia')) {
                foreach ($request->file('evidencia') as $file) {
                    $timestamp = now()->format('His');
                    $uniqueId = uniqid(); // Genera un ID único basado en el tiempo actual
                    $filename = "{$identificador}_{$timestamp}_{$uniqueId}." . $file->getClientOriginalExtension();
                    $destinationPath = storage_path("/evidencias");

                    // Crear directorio si no existe
                    File::ensureDirectoryExists($destinationPath, 0755, true);

                    // Mover el archivo a la carpeta de evidencias
                    $file->move($destinationPath, $filename);

                    // Almacenar el nombre del archivo
                    $evidenciaPaths[] = "{$filename}";
                }
            }

            // Guardar los datos del formulario en la base de datos
            $answer = Answer::create([
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

            DB::commit(); // Confirmar la transacción

            // Redirigir a la vista de completado con los datos de identificador y clave
            return redirect()->route('denuncia.completado', ['identificador' => $identificador, 'clave' => $clave])
                ->with('success', '¡Denuncia enviada con éxito!');
        } catch (\Exception $e) {
            DB::rollBack(); // Revertir la transacción si algo falla

            return redirect()->back()->withErrors('Error al procesar la denuncia. Inténtalo de nuevo.');
        }
    }*/


    public function completado(Request $request)
    {
        $identificador = $request->input('identificador');
        $clave = $request->input('clave');

        // Pasar los valores a la vista
        return view('denuncia.completado', compact('identificador', 'clave'));
    }

    public function checkStatus(Request $request)
    {
        // Validar que los campos 'numero' y 'clave' no estén vacíos
        $request->validate([
            'numero' => 'required',
            'clave' => 'required',
        ], [
            'numero.required' => 'El número de denuncia es obligatorio.',
            'clave.required' => 'La clave es obligatoria.',
        ]);

        // Obtener el número de denuncia y clave desde el request
        $numero = $request->input('numero');
        $clave = $request->input('clave');

        // Buscar en la base de datos la denuncia por identificador y clave
        $denuncia = Answer::where('identificador', $numero)
            ->where('clave', $clave)
            ->first();

        // Si no se encuentra la denuncia, redirigir con un mensaje de error
        if (!$denuncia) {
            return redirect()->back()->withErrors('No se encontró ninguna denuncia con ese identificador y clave.');
        }

        // Obtener el historial de cambios de estado de la denuncia usando su ID
        $statusHistory = AnswerStatusHistory::where('answer_id', $denuncia->id)
            ->orderBy('created_at', 'asc')
            ->get();

        // Mostrar los detalles de la denuncia encontrada junto con el historial
        return view('status.index', compact('denuncia', 'statusHistory'));
    }



    /**
     * Actualiza el estado de las denuncias de algún tenant
     */
    public function updateStatus(Request $request, $id)
    {
        // Validar el nuevo estado
        $request->validate([
            'status' => 'required|string',
        ]);

        // Buscar la denuncia
        $denuncia = Answer::findOrFail($id);

        // Registrar el cambio de estado
        $answerStatusHistory = AnswerStatusHistory::create([
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

    /**
     * Para ver el pdf que el denunciante subió
     * @param string $filename nombre del archivo
     */
    public function viewFile($filename) {
        $filename = basename($filename);  // Limpiar nombre de archivo
        $path = storage_path('/evidencias/' . $filename);

        if (!File::exists($path)) {
            abort(404);
        }

        $file = File::get($path);
        $type = File::mimeType($path);

        $response = Response::make($file, 200);
        $response->header("Content-Type", $type);

        return $response;
    }

    /**
     * Para ver el pdf del reporte del denunciante
     * @param string $filename nombre del archivo
     */
    public function viewFileReportes ($filename) {
        $path = storage_path('/reportes/' . $filename);

        if (!File::exists($path)) {
            abort(404);
        }

        $file = File::get($path);
        $type = File::mimeType($path);

        $response = Response::make($file, 200);
        $response->header("Content-Type", $type);

        return $response;
    }

    /**
     * Para descargar el archico que el denunciante subió
     * @param $filename nombre del archivo
     */
    public function downloadFile($filename) {
        $filename = basename($filename);  // Limpiar nombre de archivo
        $path = storage_path('/evidencias/' . $filename);

        if (!File::exists($path)) {
            abort(404);
        }

        $file = File::get($path);
        $type = File::mimeType($path);

        // Crear la respuesta con encabezado para forzar la descarga
        $response = Response::make($file, 200);
        $response->header('Content-Type', $type);
        $response->header('Content-Disposition', 'attachment; filename="' . $filename . '"');

        return $response;
    }

    /**
     * Para descargar el pdf del reporte del denunciante
     * @param $filename nombre del archivo
     */
    public function downloadFileReportes ($filename) {
        $path = storage_path('/reportes/' . $filename);

        if (!File::exists($path)) {
            abort(404);
        }

        $file = File::get($path);
        $type = File::mimeType($path);

        // Crear la respuesta con encabezado para forzar la descarga
        $response = Response::make($file, 200);
        $response->header('Content-Type', $type);
        $response->header('Content-Disposition', 'attachment; filename="' . $filename . '"');

        return $response;
    }
    public function evidencia(Request $request, $id)
    {
        $denuncia = Answer::findOrFail($id);
        $identificador = $denuncia->identificador;

        // Validar archivos subidos
        $request->validate([
            'evidencia.*' => 'required|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:2048', // Validaciones de tipo y tamaño
        ]);

        $evidenciaPaths = [];

        // Comprobar si se subieron archivos
        if ($request->hasFile('evidencia')) {
            foreach ($request->file('evidencia') as $file) {
                $timestamp = now()->format('His');
                $filename = "{$identificador}_{$timestamp}." . $file->getClientOriginalExtension();
                $destinationPath = 'evidencias'; // Dentro de storage/app/evidencias

                // Mover el archivo al directorio de almacenamiento usando el Storage de Laravel
                $file->storeAs($destinationPath, $filename);

                // Almacenar el nombre del archivo para la base de datos
                $evidenciaPaths[] = $filename;
            }

            // Si ya existe evidencia, combinarla con los nuevos archivos
            if (!empty($denuncia->evidencia)) {
                $evidenciaPaths = array_merge(json_decode($denuncia->evidencia, true), $evidenciaPaths);
            }

            // Actualizar el campo 'evidencia' en la base de datos (almacenar como JSON)
            $denuncia->update([
                'evidencia' => json_encode($evidenciaPaths),
            ]);

            // Mensaje de éxito
            return back()->with('success', 'Archivos subidos correctamente.');
        }

        // Manejar si no se subieron archivos
        return back()->withErrors('No se seleccionaron archivos para subir.');
    }

    public function uploadEvidencia(Request $request)
    {
        // Validar que cada archivo sea un archivo válido y cumpla con los tipos y tamaño permitidos
        $request->validate([
            'evidencia.*' => 'required|file|mimes:jpg,jpeg,png,pdf,mp3,mp4,zip|max:10240',
        ]);

        $evidenciaPaths = [];

        if ($request->hasFile('evidencia')) {
            foreach ($request->file('evidencia') as $file) {
                $identificador = strtoupper(bin2hex(random_bytes(8))); // Identificador único
                $timestamp = now()->format('His');
                $uniqueId = uniqid();
                $filename = "{$identificador}_{$timestamp}_{$uniqueId}." . $file->getClientOriginalExtension();
                $destinationPath = storage_path("/evidencias");

                // Crear directorio si no existe
                if (!File::exists($destinationPath)) {
                    File::makeDirectory($destinationPath, 0755, true);
                }

                // Mover archivo a la carpeta de evidencias
                $file->move($destinationPath, $filename);

                // Guardar el nombre del archivo
                $evidenciaPaths[] = $filename;
            }
        }

        // Retornar respuesta con los archivos subidos
        return response()->json([
            'files' => $evidenciaPaths,
            'message' => 'Archivos subidos correctamente.'
        ]);
    }

    // DenunciaController.php
    public function deleteEvidencia(Request $request)
    {
        $filename = $request->get('file'); // Nombre del archivo a eliminar
        $path = storage_path('evidencias/' . $filename);

        // Verificar si el archivo existe y eliminarlo
        if (File::exists($path)) {
            File::delete($path);
            return response()->json(['message' => 'Archivo eliminado correctamente.']);
        }

        return response()->json(['message' => 'Archivo no encontrado.'], 404);
    }

    public function downloadPdf($id)
    {
        $denuncia = Answer::findOrFail($id);

        // Generar el PDF a partir de una vista
        $pdf = Pdf::loadView('app.denuncias.pdf', compact('denuncia'));

        return $pdf->download('denuncia_' . $denuncia->identificador . '.pdf');
    }

}
