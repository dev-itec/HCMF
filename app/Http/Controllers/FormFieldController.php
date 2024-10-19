<?php
namespace App\Http\Controllers;

use App\Models\FormField;
use Illuminate\Http\Request;
use App\Models\FormSubmission;

class FormFieldController extends Controller
{
    public function showForm()
    {
        // campos activos agrupados por categoria
        $fields = FormField::where('active', true)
                           ->orderBy('category')
                           ->get()
                           ->groupBy('category');

                           $formSubmissions = FormSubmission::all(); // esto trae toda la data del json


        return view('forms.form', compact('fields', 'formSubmissions'));
    }

     
    public function submitForm(Request $request)
{
    // // de alguna manera hacer validaciones
    // $validatedData = $request->validate([
    //     'nombre' => 'required|string|max:255',
    //     'email' => 'required|email',
    //     // ???????
    // ]);

    // json pa la BD
    FormSubmission::create([
        'data' => json_encode($request->all()),
    ]);

    return redirect()->back()->with('success', 'Formulario enviado correctamente.');
}
}
