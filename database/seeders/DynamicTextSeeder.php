<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DynamicTextSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DynamicText::create([
            'texto' => 'Texto para la sección home',
            'seccion' => 'home-section',
        ]);

        DynamicText::create([
            'texto' => 'Texto para la sección de quejas',
            'seccion' => 'end-complaint-section',
        ]);

        DynamicText::create([
            'texto' => 'Texto para el cuerpo del correo',
            'seccion' => 'email-body',
        ]);
    }
}
