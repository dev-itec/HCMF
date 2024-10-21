<?php

namespace App\Http\Controllers;

use App\Models\FormField; // Asegúrate de que sea el nombre correcto del modelo
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() {
        $formFields = FormField::all(); // Obtiene todos los campos de formulario sin orden específico
        return view('app.form_fields.index', compact('formFields'));
    }

    public function create() {
        $formFields = FormField::all(); // Obtiene todos los campos de formulario para la vista de creación
        return view('app.questions.create', compact('formFields'));

    }

    public function store(Request $request) {
        // Validar los datos
        $request->validate([
            'labels.*' => 'required|string|max:255',
            'types.*' => 'required|string|in:text,checkbox,dropdown,date', // Tipos de campo permitidos
            'categories.*' => 'required|string|max:255',
            'active.*' => 'boolean', // Campo activo como booleano
            'additional_infos.*' => 'nullable|string|max:255',
        ]);
    
        foreach ($request->labels as $index => $label) {
            // Verificar si existe un ID y que el ID no sea nulo o vacío
            $id = $request->ids[$index] ?? null;
    
            if ($id) {
                // Si el ID existe, intenta encontrar el campo correspondiente
                $formField = FormField::find($id);
    
                if ($formField) {
                    // Actualizar el campo existente
                    $formField->update([
                        'label' => $label,
                        'type' => $request->types[$index],
                        'category' => $request->categories[$index],
                        'active' => isset($request->active[$index]) ? 1 : 0,
                        'additional_info' => $request->additional_infos[$index] ?? null,
                    ]);
                }
            } else {
                // Si no hay ID, crear un nuevo registro
                FormField::create([
                    'label' => $label,
                    'type' => $request->types[$index],
                    'category' => $request->categories[$index],
                    'active' => isset($request->active[$index]) ? 1 : 0,
                    'additional_info' => $request->additional_infos[$index] ?? null,
                ]);
            }
        }
    
        // Manejar eliminación de campos
        if ($request->filled('deletedQuestions')) {
            $deletedIds = explode(',', $request->deletedQuestions);
            FormField::destroy($deletedIds); // Elimina los campos especificados
        }
    
        return redirect()->back()->with('success', 'Formulario guardado correctamente.');
    }
    

    public function edit(FormField $formField) {
        return view('app.form_fields.edit', compact('formField'));
    }

    public function update(Request $request, FormField $formField) {
        $data = $request->validate([
            'label' => 'required|string|max:255',
            'type' => 'required|string|in:text,checkbox,dropdown,date',
            'category' => 'required|string|max:255',
            'active' => 'boolean',
            'additional_info' => 'nullable|string|max:255',
        ]);

        // Actualizar el campo
        $formField->update($data);

        return redirect()->route('form_fields.edit', $formField->id)->with('success', 'Campo actualizado exitosamente.');
    }

    public function destroy(FormField $formField) {
        $formField->delete();
        return redirect()->route('form_fields.create')->with('success', 'Campo eliminado correctamente.');
    }
}
