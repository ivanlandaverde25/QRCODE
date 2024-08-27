<?php

namespace Database\Seeders;

use App\Models\Medico;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        $medico = new Medico();
        $medico->nombre = 'Ivan Mendoza Landaverde';
        $medico->tipo_documento = 'DUI';
        $medico->documento = '06208269-4';
        $medico->correo = 'ivanmendoza572@gmail.com';

        $medico->save();

        Medico::factory(100)->create();
    }
}
