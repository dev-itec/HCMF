<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAnswerRequest;
use App\Http\Requests\UpdateAnswerRequest;
use App\Models\Answer;

class AnswerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAnswerRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $denuncia = Answer::findOrFail($id);
        $historial = AnswerStatusHistory::where('answer_id', $id)->orderBy('created_at', 'desc')->get();

        return view('answers.show', compact('denuncia', 'historial'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Answer $answer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAnswerRequest $request, Answer $answer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Answer $answer)
    {
        //
    }
    /**
     * Update the specified resource in storage.
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

        return response()->json(['success' => true]);
    }
}
