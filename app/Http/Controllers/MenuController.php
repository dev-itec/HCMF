<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Resolucion;
use App\Models\Tenant;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class MenuController extends Controller
{
    public function index()
    {
        $meses = [
            1 => 'Ene',
            2 => 'Feb',
            3 => 'Mar',
            4 => 'Abr',
            5 => 'May',
            6 => 'Jun',
            7 => 'Jul',
            8 => 'Ago',
            9 => 'Sep',
            10 => 'Oct',
            11 => 'Nov',
            12 => 'Dic'
        ];
        // Consultas de estadísticas
        $totalDenuncias = Answer::count();
        $denunciasCerradas = Answer::where('status', 'resuelta')->count();
        $promedioCierre = Answer::where('status', 'resuelta')
            ->selectRaw('AVG(DATEDIFF(updated_at, created_at)) as promedio_dias')
            ->value('promedio_dias');
        $historicoMensual = Answer::selectRaw('MONTH(created_at) as mes, COUNT(*) as total')
            ->groupBy('mes')
            ->pluck('total', 'mes')->all();
        $categorizacionDenuncias = Answer::whereMonth('created_at', Carbon::now()->month)
            ->selectRaw('tipo_denuncia, COUNT(*) as total')
            ->groupBy('tipo_denuncia')
            ->pluck('total', 'tipo_denuncia')->all();
        $denunciasPorGenero = Answer::whereMonth('created_at', Carbon::now()->month)
            ->selectRaw('genero, COUNT(*) as total')
            ->groupBy('genero')
            ->pluck('total', 'genero')->all();

        // Convertir números de meses a nombres de meses
        $historicoMensualConNombres = [];
        foreach ($historicoMensual as $mes => $total) {
            $historicoMensualConNombres[$meses[$mes]] = $total;
        }

        // Pasar los datos a la vista
        return view('app.dashboard', [
            'totalDenuncias' => $totalDenuncias,
            'denunciasCerradas' => $denunciasCerradas,
            'promedioCierre' => round($promedioCierre, 2),
            'historicoMensual' => $historicoMensualConNombres,
            'categorizacionDenuncias' => $categorizacionDenuncias,
            'denunciasPorGenero' => $denunciasPorGenero,
        ]);
    }

    public function denuncias()
    {
        $answers = Answer::all();
        return view('app.denuncias.index', compact('answers'));
    }

    public function reportes()
    {
        $answers = Answer::all()->where('status', 'resuelta');
        return view('app.reportes.index', compact('answers'));
    }

    public function formulario()
    {
        return view('app.formulario.index');
    }

    public function opciones()
    {
        return view('app.opciones.index');
    }
    public function cerrarCaso(Request $request, $id)
    {
        $validatedData = $request->validate([
            'texto_resolucion' => 'required|string',
            'pdf' => 'nullable|file|mimes:pdf|max:2048', // 2MB max para el PDF
        ]);

        // Buscar la denuncia por su ID
        $denuncia = Answer::findOrFail($id);

        // Manejar la subida del archivo PDF
        $rutaArchivo = null;
        if ($request->hasFile('pdf')) {
            $archivo = $request->file('pdf');
            $nombreArchivo = $denuncia->identificador . '.' . $archivo->getClientOriginalExtension();
            $rutaArchivo = $archivo->storeAs("tenants/{$denuncia->tenant_id}/resoluciones", $nombreArchivo, 'public');
        }

        // Guardar la resolución en la base de datos
        Resolucion::updateOrCreate(
            ['denuncia_id' => $denuncia->id],
            [
                'identificador' => $denuncia->identificador,
                'texto_resolucion' => $request->input('texto_resolucion'),
                'pdf' => $rutaArchivo,
            ]
        );

        // Cambiar el estado a "resuelta"
        $denuncia->update(['status' => 'resuelta']);

        return response()->json(['success' => true]);
    }
    public function download($tenant, $file)
    {
        $path = "tenants/{$tenant}/resoluciones/{$file}";

        if (Storage::exists($path)) {
            return Storage::download($path);
        } else {
            abort(404, 'Archivo no encontrado.');
        }
    }
    public function verPdf($id)
    {
        // Buscar la resolución por el ID de la denuncia
        $resolucion = Resolucion::where('denuncia_id', $id)->firstOrFail();

        // Retornar la ruta del archivo PDF para mostrarlo en el modal
        return response()->json(['pdf' => $resolucion->pdf]);
    }

}
