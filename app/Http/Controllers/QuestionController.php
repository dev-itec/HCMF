<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreQuestionRequest;
use App\Http\Requests\UpdateQuestionRequest;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() {
        $questions = Question::orderBy('order')->get();
        return view('app.questions.index', compact('questions'));
    }

    public function create()
    {
        $questions = Question::orderBy('order')->get();
        return view('app.questions.create', compact('questions'));
    }


    public function store(Request $request) {
        // Validar los datos
        $request->validate([
            'labels.*' => 'required|string|max:255',
            'types.*' => 'required|string|in:text,checkbox,select',
            'placeholders.*' => 'nullable|string|max:255',
            'options.*' => 'nullable|string|max:255',
        ]);

        // Guardar solo registros nuevos
        foreach ($request->labels as $index => $label) {
            // Verificar si la pregunta ya existe
            $existingQuestion = Question::where('label', $label)->first();

            // Si no existe, guardarlo
            if (!$existingQuestion) {
                Question::create([
                    'label' => $label,
                    'type' => $request->types[$index],
                    'placeholder' => $request->placeholders[$index],
                    'options' => $request->options[$index] ? explode(',', $request->options[$index]) : null,
                ]);
            }
        }

        return redirect()->back()->with('success', 'Formulario guardado correctamente.');
    }

    public function edit(Question $question) {
        if (is_string($question->options)) {
            $question->options = json_decode($question->options, true);
        }

        if (is_string($question->validation_rules)) {
            $question->validation_rules = json_decode($question->validation_rules, true);
        }

        return view('app.questions.edit', compact('question'));
    }


    public function update(Request $request, Question $question) {
        $data = $request->validate([
            'label' => 'required|string|max:255',
            'type' => 'required|string|in:text,date,select,checkbox',
            'placeholder' => 'nullable|string|max:255',
            'help_text' => 'nullable|string',
            'validation_rules' => 'nullable|string',
            'options' => 'nullable|string',
            'order' => 'nullable|integer',
            'required' => 'boolean',
        ]);

        // Handle options field
        if ($request->has('options') && ($data['type'] == 'select' || $data['type'] == 'checkbox')) {
            $data['options'] = json_encode(array_map('trim', explode(',', $data['options'])));
        } else {
            $data['options'] = null;
        }

        // Handle validation rules as JSON
        if ($request->has('validation_rules')) {
            $data['validation_rules'] = json_encode(array_map('trim', explode('|', $data['validation_rules'])));
        }

        // Update the question
        $question->update($data);

        return redirect()->route('questions.edit', $question->id)->with('success', 'Pregunta actualizada exitosamente.');
    }


    public function updateOrder(Request $request) {
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
