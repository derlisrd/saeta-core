<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Cliente;
use App\Models\Deposito;
use App\Models\Empresa;
use App\Models\Impuesto;
use App\Models\Medida;
use App\Models\Sucursal;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ExampleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Impuesto::create([
            'descripcion'=>'Ninguno',
            'valor'=>0
        ]);
        Category::create([
            'nombre'=>'Ninguna'
        ]);
        
        Cliente::create([
            'doc'=>'x',
            'nombres'=>'Sin nombre'
        ]);
        Medida::create([
            'descripcion'=>'Unidad',
            'abreviatura' =>'u'
        ]);
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
        Deposito::create([
            'sucursal_id'=>$sucursal->id,
            'nombre'=>'Principal'
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
