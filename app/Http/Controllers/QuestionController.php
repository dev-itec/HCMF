<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreQuestionRequest;
use App\Http\Requests\UpdateQuestionRequest;
use App\Models\Question;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() {
        $questions = Question::orderBy('order')->get();
        return view('app.questions.index', compact('questions'));
    }

    public function create() {
        $questions = Question::all();
        return view('app.questions.create', compact('questions'));
    }

    public function store(Request $request) {
        $data = $request->validate([
            'label' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'type' => 'required|string|in:text,date,select,checkbox',
            'options' => 'nullable|string', // Opciones como cadena de texto
            'order' => 'nullable|integer',
            'required' => 'boolean',
        ]);

        // Convertir las opciones en un array si es necesario
        if (!empty($data['options'])) {
            $data['options'] = explode(',', $data['options']);
        }

        Question::create($data);

        return redirect()->route('questions.create');
    }

    public function edit(Question $question)
    {
        // Decodificar opciones solo si es un string
        if (is_string($question->options)) {
            $question->options = json_decode($question->options, true);
        }
        return view('app.questions.edit', compact('question'));
    }

    public function update(Request $request, Question $question)
    {
        // Validar los datos
        $data = $request->validate([
            'label' => 'required|string|max:255',
            'type' => 'required|string|in:text,date,select,checkbox',
            'options' => 'nullable|string',  // Asegúrate de recibirlo como una cadena
            'order' => 'nullable|integer',
            'required' => 'boolean',
        ]);

        // Si hay opciones y el tipo de pregunta es select o checkbox, procesa las opciones
        if ($request->has('options') && ($data['type'] == 'select' || $data['type'] == 'checkbox')) {
            $data['options'] = json_encode(array_map('trim', explode(',', $request->options)));
        } else {
            $data['options'] = null;  // Si no hay opciones o no aplica, asegúrate de limpiar el campo
        }

        // Actualizar la pregunta
        $question->update($data);

        // Redireccionar a la página de edición o lista de preguntas
        return redirect()->route('questions.edit', $question->id)->with('success', 'Pregunta actualizada exitosamente');
    }



    public function updateOrder(Request $request)
    {
        foreach ($request->questions as $question) {
            Question::where('id', $question['id'])
                ->update(['order' => $question['position']]);
        }

        return response()->json(['success' => true]);
    }


    public function destroy(Question $question) {
        $question->delete();
        return redirect()->route('questions.create')->with('success', 'Pregunta eliminada correctamente.');
    }
}
