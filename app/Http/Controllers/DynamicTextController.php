<?php

namespace App\Http\Controllers;

use App\Models\DynamicText;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DynamicTextController extends Controller
{
    /**
     * Para ir a vista de textos dinámicos
     */
    public function dynamicTextView()
    {
        try {
            $dynamicTexts = DynamicText::all();
            $message = "";

            if(!empty($dynamicTexts)) {
                return view('app.dynamic-text.index', compact('dynamicTexts', 'message'));
            } 
        } catch (Exception $e) {
            Log::error('Existe un error al buscar todos los textos dinámicos para las secciones: ' . $e);
            return response()->json(['message' => 'Ocurrió un error al intentar buscar los textos dinámicos'], 500);
        }
        
    }

    /**
     * Guarda el texto con su respectiva ubicación para la base de datos
     */
    public function saveText(Request $request)
    {
        DB::beginTransaction();

        try {
            $request->validate([
                'texto' => 'required|string',
                'seccion' => 'required|string'
            ]);

            $dynamicTexts = DynamicText::where('seccion', $request->seccion)->get();
            $dynamicText = null;
            $message = "";

            if(!empty($dynamicTexts)) {
                foreach($dynamicTexts as $dynamicText) {
                    $dynamicText->texto = $request->texto;

                    $dynamicText->save();
                }

                $message = "Datos actualizados correctamente";
            } else {
                $dynamicText = DynamicText::create([
                    'texto' => $request->texto,
                    'seccion' => $request->seccion
                ]);
            }

            DB::commit();

            $dynamicTexts = DynamicText::all();

            if(!empty($dynamicTexts)) {
                return view('app.dynamic-text.index', compact('dynamicTexts', 'message'));
            } 
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Existe un error al intentar guardar el texto para la sección: ' . $e);
            return response()->json(['message' => 'Ocurrió un error al intentar guardar el texto'], 500);
        }
    }

    /**
     * Trae el texto para una sección especificada
     */
    public function getText($section)
    {
        if (empty($section)) {
            return response()->json(['message' => 'La sección es requerida'], 400);
        }

        try {

            $dynamicText = DynamicText::where('seccion', $request->seccion)->first();

            if ($dynamicText) {
                return response()->json([
                    'success' => true,
                    'data' => $dynamicText
                ]);
            } else {
                return response()->json(['message' => 'No se encontró el texto para la sección especificada'], 404);
            }
        } catch (Exception $e) {
            Log::error('Error al obtener el texto: ' . $e->getMessage());
            return response()->json(['message' => 'Ocurrió un error al obtener el texto'], 500);
        }
    }

    /**
     * Para editar uno de los textos guardados en base de datos
     */
    public function editText($section)
    {
        if (empty($section)) {
            return response()->json(['message' => 'La sección es requerida'], 400);
        }

        DB::beginTransaction();

        try {
            $request->validate([
                'seccion' => 'required|string'
            ]);

            $dynamicText = DynamicText::where('seccion', $request->seccion)->first();

            if ($dynamicText) {
                $dynamicText->texto = $request->texto;

                $dynamicText->save();

                DB::commit();
            } else {
                return response()->json(['message' => 'No se encontró el texto para la sección especificada'], 404);
            }

            return response()->json(['message' => 'Texto actualizado con éxito', 'dynamicText' => $dynamicText], 200);
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Existe un error al tomar el texto de la base de datos: ' . $e);
            return response()->json(['message' => 'Ocurrió un error al intentar actualizar el texto'], 500);
        }
    }

    /**
     * Funciona para eliminar un texto x's guardado en la base de datos según una seccion especificada
     */
    public function deleteText($section)
    {
        if (empty($section)) {
            return response()->json(['message' => 'La sección es requerida'], 400);
        }

        DB::beginTransaction();

        try {
            $request->validate([
                'seccion' => 'required|string'
            ]);

            $dynamicText = DynamicText::where('seccion', $request->seccion);

            if ($dynamicText) {
                $dynamicText->delete;

                DB::commit();
                return response()->json([
                    'success' => true,
                    'message' => 'Texto eliminado correctamente',
                ]);
            } else {
                return response()->json(['message' => 'No se encontró el texto para la sección especificada'], 404);
            }
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Existe un error al eliminar el texto de la base de datos: ' . $e);
            return response()->json(['message' => 'Ocurrió un error al intentar eliminar el texto'], 500);
        }
    }
}
