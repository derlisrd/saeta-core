<?php

namespace App\Http\Controllers\Ecommerce;

use App\Http\Controllers\Controller;
use App\Models\Producto;
use Illuminate\Http\Request;

class ProductosController extends Controller
{
    public function productos(){
        $productos = Producto::where('disponible', 1)
        ->where('tipo',1)
        ->with('images')
            ->select('id', 'nombre','codigo','precio_normal', 'descripcion', 'disponible','precio_descuento')
        ->get();
        return view('ecommerce.productos', compact('productos'));
    }
}
