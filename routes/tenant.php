<?php

declare(strict_types=1);

use App\Http\Controllers\AnswerController;
use App\Http\Controllers\App\TenantSettingController;
use App\Http\Controllers\FormController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\DenunciaController;
use App\Http\Controllers\App\ProfileController;
use App\Http\Controllers\App\UserController;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;
use App\Http\Controllers\App\UserPasswordController;
use App\Http\Controllers\GenerateZipControlador;


/*
|--------------------------------------------------------------------------
| Tenant Routes
|--------------------------------------------------------------------------
|
| Here you can register the tenant routes for your application.
| These routes are loaded by the TenantRouteServiceProvider.
|
| Feel free to customize them however you want. Good luck!
|
*/

Route::middleware([
    'web',
    InitializeTenancyByDomain::class,
    PreventAccessFromCentralDomains::class,
])->group(function () {
    /*
        Route::get('/', function () {
            dd(tenant()->toArray());
            return 'This is your multi-tenant application. The id of the current tenant is ' . tenant('id');
        });
    */

    Route::get('/', function () {
        return view('app.welcome');
    });

    Route::get('/api/employees', function () {
        $response = Http::withHeaders([
            'Authorization' => 'Token ' . tenant()->api_key,
        ])->get('https://api.hcmfront.com/v1/employee/');

        return $response->json();
    });

    /*
        Route::get('/dashboard', function () {
        return view('app.dashboard');
        })->middleware(['auth', 'verified'])->name('dashboard');
    */
    Route::get('/denuncia/status', [DenunciaController::class, 'checkStatus'])->name('denuncia.status');
    Route::post('/denuncia/{id}/evidencia', [DenunciaController::class, 'evidencia'])->name('denuncia.evidencia');
    Route::get('/denuncia/{tenant_id}/create', [DenunciaController::class, 'create'])->name('denuncia.create');
    Route::post('/denuncia/store', [DenunciaController::class, 'store'])->name('denuncia.store');
    Route::get('/denuncia/completado', [DenunciaController::class, 'completado'])->name('denuncia.completado');

    Route::get('/denuncia/{id}', [FormController::class, 'show'])->name('forms.show');
    Route::post('/answers', [AnswerController::class, 'store']);

    Route::post('/upload-evidencia', [DenunciaController::class, 'uploadEvidencia'])->name('upload.evidencia');
    Route::delete('/delete-evidencia', [DenunciaController::class, 'deleteEvidencia'])->name('delete.evidencia');

    Route::post('/users/{user}/password/reset', [UserPasswordController::class, 'sendResetLink'])->name('users.password.reset');


    Route::middleware('auth')->group(function () {
        Route::get('/generate-zip', GenerateZipControlador::class)->name('generate-zip');
        Route::get('/dashboard', [MenuController::class, 'index'])->name('dashboard');

        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');



        Route::get('/denuncias', [MenuController::class, 'denuncias'])->name('denuncias.index');
        Route::post('/denuncias/{id}/status', [DenunciaController::class, 'updateStatus']);
        Route::get('/reportes', [MenuController::class, 'reportes'])->name('reportes.index');
        Route::post('/denuncias/{id}/cerrar', [MenuController::class, 'cerrarCaso'])->name('denuncias.cerrar');
        Route::get('/denuncias/{id}/ver-pdf', [MenuController::class, 'verPdf']);
        Route::get('/denuncias/{id}/pdf', [DenunciaController::class, 'downloadPdf'])->name('denuncia.pdf');

        Route::get('/resolucion/{tenant}/{file}', [MenuController::class, 'download']);

        Route::get('/formulario', [MenuController::class, 'formulario'])->name('formulario.index');

        Route::get('/opciones', [MenuController::class, 'opciones'])->name('opciones.index');

        Route::get('/file/view/{filename}', [DenunciaController::class, 'viewFile'])->name('file.view');
        Route::get('/file/download/{filename}', [DenunciaController::class, 'downloadFile'])->name('file.download');


        Route::get('/file/{filename}/reportes', [DenunciaController::class, 'viewFileReportes'])->name('file.reportes.view');
        Route::get('/file/download/{filename}/reportes', [DenunciaController::class, 'downloadFileReportes'])->name('file.reportes.download');

        Route::group(['middleware' => ['role:admin']], function () {
            Route::resource('users', UserController::class);
            Route::resource('questions', QuestionController::class);
            Route::get('questions/create', [QuestionController::class, 'create'])->name('questions.create'); // GET para mostrar el formulario
            Route::post('questions', [QuestionController::class, 'store'])->name('questions.store');         // POST para almacenar los datos
            Route::post('questions/update-order', [QuestionController::class, 'updateOrder'])->name('questions.updateOrder');
            Route::delete('questions/{question}', [QuestionController::class, 'destroy'])->name('questions.destroy');
            Route::get('questions/{question}/edit', [QuestionController::class, 'edit'])->name('questions.edit');
            Route::put('questions/{question}', [QuestionController::class, 'update'])->name('questions.update');

            //Route::resource('opciones', TenantSettingController::class);
            // Ruta para listar las configuraciones (index)
            Route::get('/opciones/vars', [TenantSettingController::class, 'index'])->name('app.opciones.vars');
            // Ruta para crear una nueva configuración (create)
            Route::get('/opciones/create', [TenantSettingController::class, 'create'])->name('app.opciones.create');
            // Ruta para almacenar una nueva configuración (store)
            Route::post('/opciones', [TenantSettingController::class, 'store'])->name('app.opciones.store');
            // Ruta para editar una configuración existente (edit)
            Route::get('/opciones/{tenantSetting}/edit', [TenantSettingController::class, 'edit'])->name('app.opciones.edit');
            // Ruta para actualizar una configuración existente (update)
            Route::put('/opciones/{tenantSetting}', [TenantSettingController::class, 'update'])->name('app.opciones.update');
            // Ruta para eliminar una configuración (destroy)
            Route::delete('/opciones/{tenantSetting}', [TenantSettingController::class, 'destroy'])->name('app.opciones.destroy');

            Route::resource('forms', FormController::class);
            Route::get('forms/create', [FormController::class, 'create'])->name('forms.create');
            Route::post('forms', [FormController::class, 'store'])->name('forms.store');
            Route::get('forms', [FormController::class, 'index'])->name('forms.index');
            Route::get('forms/{form}/edit', [FormController::class, 'edit'])->name('forms.edit');
            Route::put('/forms/{id}', [FormController::class, 'update'])->name('forms.update');





        });
    });


    require __DIR__ . '/tenant-auth.php';
});
