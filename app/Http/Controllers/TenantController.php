<?php

namespace App\Http\Controllers;

use App\Mail\WelcomeTenantMail;
use App\Models\Tenant;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;

class TenantController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tenants = Tenant::with('domains')->get();

        return view('tenants.index', ['tenants' => $tenants]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('tenants.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validación
        $validatedData = $request->validate([
            'name'        => 'required|string|max:255',
            'email'       => 'required|email|max:255',
            'domain_name' => 'required|string|max:255|unique:domains,domain',
            'api_key'     => 'required|string|max:255', // Nueva validación para el campo API Key
            'password'    => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // Cifrado de la contraseña
        $validatedData['password'] = Hash::make($validatedData['password']);

        Log::info('password created:' . " " . $validatedData['password']);

        // Crear el tenant
        $tenant = Tenant::create($validatedData);

        Log::info('Checking pass: ' . Hash::check($validatedData['password'], $tenant['password']));

        Log::info('password created in tenant:' . " " . $tenant['password']);

        // Enviar el correo de bienvenida
        Mail::to($validatedData['email'])->send(new WelcomeTenantMail($tenant));


        // Crear el dominio asociado
        $tenant->domains()->create([
            'domain' => $validatedData['domain_name'] . '.' . config('app.domain'),
        ]);
        
        
        return redirect()->route('tenants.index');
    }


    /**
     * Display the specified resource.
     */
    public function show(Tenant $tenant)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tenant $tenant)
    {
        return view('tenants.edit', compact('tenant'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Tenant $tenant)
    {
        // Validación
        $validatedData = $request->validate([
            'name'        => 'required|string|max:255',
            'email'       => 'required|email|max:255',
            'domain_name' => 'required|string|max:255|unique:domains,domain,' . $tenant->domains->first()->id,
            'password'    => ['nullable', 'confirmed', Rules\Password::defaults()],
            'api_key'     => 'nullable|string|max:255',
        ]);

        // Si se proporcionó una nueva contraseña, se cifra
        if (!empty($validatedData['password'])) {
            $validatedData['password'] = Hash::make($validatedData['password']);
        } else {
            unset($validatedData['password']); // No cambiar la contraseña si no se proporcionó
        }

        // Actualizar el tenant
        $tenant->update($validatedData);
        // dd($tenant);

        // Actualizar el dominio asociado
        if ($tenant->domains->isNotEmpty()) {
            $tenant->domains()->update([
                'domain' => $validatedData['domain_name'] . '.' . config('app.domain'),
            ]);
        }

        return redirect()->route('tenants.index')->with('success', 'Cliente actualizado con éxito.');
    }


    /**
     * Remove the specified resource from storage.
     */
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tenant $tenant)
    {
        // Eliminar el tenant y sus dominios asociados
        $tenant->domains()->delete();
        $tenant->delete();

        return redirect()->route('tenants.index')->with('success', 'Cliente eliminado con éxito.');
    }

}
