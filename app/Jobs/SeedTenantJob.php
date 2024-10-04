<?php

namespace App\Jobs;

use App\Models\Tenant;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SeedTenantJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    protected $tenant;
    public function __construct(Tenant $tenant)
    {
        $this->tenant = $tenant;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $this->tenant->run(function () {
            // Verificar si el rol "admin" existe, si no, crearlo
            if (!\Spatie\Permission\Models\Role::where('name', 'admin')->exists()) {
                \Spatie\Permission\Models\Role::create(['name' => 'admin']);
            }

            // Crear el usuario
            $user = User::create([
                'name'     => $this->tenant->name,
                'email'    => $this->tenant->email,
                'password' => $this->tenant->password,
            ]);

            // Asignar el rol
            $user->assignRole('admin');
        });
    }
}
