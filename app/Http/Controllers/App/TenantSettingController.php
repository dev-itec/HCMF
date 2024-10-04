<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use App\Models\TenantSetting;
use Illuminate\Http\Request;

class TenantSettingController extends Controller
{
    public function index()
    {
        $tenantSettings = TenantSetting::all();
        return view('app.opciones.vars', compact('tenantSettings'));
    }

    public function create()
    {
        return view('app.opciones.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'value' => 'nullable|string|max:255',
        ]);

        TenantSetting::create($validatedData);

        return redirect()->route('app.opciones.vars')->with('success', 'Configuración creada exitosamente.');
    }

    public function edit(TenantSetting $tenantSetting)
    {
        return view('app.opciones.edit', compact('tenantSetting'));
    }

    public function update(Request $request, TenantSetting $tenantSetting)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'value' => 'nullable|string|max:255',
        ]);

        $tenantSetting->update($validatedData);

        return redirect()->route('app.opciones.vars')->with('success', 'Configuración actualizada exitosamente.');
    }

    public function destroy(TenantSetting $tenantSetting)
    {
        $tenantSetting->delete();

        return redirect()->route('app.opciones.vars')->with('success', 'Configuración eliminada exitosamente.');
    }
}
