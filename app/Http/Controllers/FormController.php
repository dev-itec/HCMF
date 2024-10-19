<?php

namespace App\Http\Controllers;

use App\Models\Form; // Asegúrate de tener este modelo
use Illuminate\Http\Request;

class FormController extends Controller
{
    // Mostrar el formulario de creación
    public function create()
    {
        return view('app.formulario.create'); // Crea esta vista
    }

    // Almacenar el formulario
    public function store(Request $request)
    {
        // Validar los datos recibidos
        $request->validate([
            'name' => 'required|string|max:255', // Nombre del formulario
            'data' => 'required|json', // Asegurarse de que 'data' es un JSON válido
        ]);

        // Crear el formulario, asegurando que 'data' se guarda como JSON
        Form::create([
            'name' => $request->name,
            'data' => $request->data, // Aquí almacenas el JSON
        ]);

        return redirect()->route('forms.index')->with('success', 'Formulario guardado exitosamente.');
    }

    // Listar formularios
    public function index()
    {
        $forms = Form::all(); // Recupera todos los formularios
        return view('app.formulario.index', compact('forms')); // Crea esta vista
    }

    // Mostrar el formulario para editar
    public function edit($id)
    {
        $form = Form::findOrFail($id);
        return response()->json($form);
    }

    // Actualizar el formulario
    public function update(Request $request, $id)
    {
        $form = Form::findOrFail($id);
        $form->name = $request->name;
        $form->data = $request->data; // Asegúrate de manejar correctamente los datos del formulario
        $form->save();

        return response()->json(['message' => 'Formulario actualizado exitosamente']);
    }


    // Eliminar el formulario
    public function destroy($id)
    {
        $form = Form::findOrFail($id);
        $form->delete();

        return redirect()->route('forms.index')->with('success', 'Formulario eliminado exitosamente.');
    }

    public function show($id)
    {
        // Recuperar el formulario específico o lanzar un 404 si no se encuentra
        $form = Form::findOrFail($id);

        // Devolver la vista con el formulario
        return view('app.formulario.show', compact('form')); // Asegúrate de crear esta vista
    }
}

