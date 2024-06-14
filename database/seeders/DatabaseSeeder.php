<?php

namespace Database\Seeders;

use App\Models\Empresa;
use App\Models\Sucursal;
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
        $empresa = Empresa::create([
            'nombre'=>'Nombre de empresa',
            'ruc'=>'0000',
            'telefono'=>'0983200900',
            'direccion'=>'cde',
            'licencia'=>'2026-01-01',
        ]);
        $sucursal = Sucursal::create([
            'empresa_id'=>$empresa->id,
            'nombre'=>'Nombre sucursal',
            'descripcion'=>'Descripcion sucursal',
            'direccion'=>'direccion sucursal',
            'telefono'=>'0000',
            'numero'=>1
        ]);
        User::factory()->create([
            'name' => 'Derlis',
            'username'=>env('USER_SEED','user'),
            'email' => env('EMAIL_SEED','demo@demo.com'),
            'password'=>env('PASSWORD_SEED',123456),
            'empresa_id'=> $empresa->id,
            'sucursal_id'=> $sucursal->id
        ]);
        
    }
}
