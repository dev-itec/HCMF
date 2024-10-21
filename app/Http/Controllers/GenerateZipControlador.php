<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use ZipArchive;
use File;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Resolucion;
use App\Models\Answer;

class GenerateZipControlador extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $tenan = $request->query('tenan');
        $denunciaId = $request->query('denuncia_id');
        $comment = Resolucion::where('denuncia_id',$denunciaId)->first();
        
        $this->savePdf($denunciaId, $comment->texto_resolucion);
        $zip = new \ZipArchive();
        $zip_file = 'reportes.zip';

        $zip->open($zip_file, \ZipArchive::CREATE | \ZipArchive::OVERWRITE);

        $path = storage_path($tenan);
        $files = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($path));
        foreach ($files as $name => $file)
        {
            // We're skipping all subfolders
            if (!$file->isDir()) {
                $filePath     = $file->getRealPath();

                // extracting filename with substr/strlen
                $relativePath = '/' . substr($filePath, strlen($path) + 1);

                $zip->addFile($filePath, $relativePath);
            }
        }
        $zip->close();
        return response()->download($zip_file);
    }


private function savePdf($id, $texto_resolucion)
{
    $denuncia = Answer::findOrFail($id);

    $imagePath = public_path('img/logo_hcm.png');
    
    $imageData = base64_encode(file_get_contents($imagePath));
    $src = 'data:image/png;base64,' . $imageData;

    $showComment = true;
    // Genera el PDF usando una vista
    $pdf = Pdf::loadView('app.denuncias.pdf', compact('denuncia', 'src', 'showComment', 'texto_resolucion'));

    $pdf->setOption('footer-center', 'Generado el ' . now()->format('d-m-Y'));
    $pdf->setOption('footer-font-size', '10');

    // Nombre del archivo PDF
    $fileName = $denuncia->identificador . '.pdf';

    $pdfPath = storage_path('resolucion/' . $fileName);

    if (!file_exists(dirname($pdfPath))) {
        mkdir(dirname($pdfPath), 0755, true);
    }

    file_put_contents($pdfPath, $pdf->output());

    return $pdfPath;
}


}
