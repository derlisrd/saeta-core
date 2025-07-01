<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Cliente;
use App\Models\Deposito;
use App\Models\Empresa;
use App\Models\FormasPago;
use App\Models\Impuesto;
use App\Models\Medida;
use App\Models\Moneda;
use App\Models\Permiso;
use App\Models\PermisosOtorgado;
use App\Models\Sucursal;
use App\Models\User;
use Illuminate\Database\Seeder;

class ExampleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Impuesto::create([
            'descripcion'=>'Exenta',
            'valor'=>0,
            'porcentaje'=>'0%'
        ]);
        Impuesto::create([
            'descripcion'=>'5%',
            'valor'=>5,
            'porcentaje'=>'5%'
        ]);
        Impuesto::create([
            'descripcion'=>'10%',
            'valor'=>10,
            'porcentaje'=>'10%'
        ]);
        Category::create([
            'nombre'=>'Sin categoría'
        ]);
        
        Cliente::create([
            'doc'=>'x',
            'nombres'=>'Sin nombre',
            'razon_social'=>'Sin nombre',
        ]);
        Medida::create([
            'descripcion'=>'Unidad',
            'abreviatura' =>'u',
            'default'=>true
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
        FormasPago::create([
            'tipo'=>1,
            'condicion' => 'contado',
            'descripcion'=>'Efectivo'
        ]);
        
        User::factory()->create([
            'name' => 'Mantenimiento',
            'username'=>env('USER_SEED','user'),
            'email' => env('EMAIL_SEED','demo@demo.com'),
            'password'=>env('PASSWORD_SEED',123456),
            'empresa_id'=> $empresa->id,
            'sucursal_id'=> $sucursal->id,
            'tipo'=>10,
            'hidden' => 1
        ]);
        Permiso::create([
            'modulo' => 'Usuarios',
            'accion'=>'Administrar usuarios'
        ]);
        PermisosOtorgado::create([
            'user_id'=>1,
            'permiso_id'=>1,
            'otorgado'=>true
        ]);
        Moneda::create([
            'nombre'=>'Guaraníes',
            'simbolo'=>'Gs',
            'default'=>true
        ]);
    }
}
