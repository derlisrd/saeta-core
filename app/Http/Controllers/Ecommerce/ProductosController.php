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
        ->with(['category','images'])
        ->select('id', 'nombre','codigo','precio_normal', 'descripcion', 'disponible','precio_descuento','descuento_activo','tipo','precio_minimo','category_id')
        ->get();
        //dd($productos);
        return view('ecommerce.productos', compact('productos'));
    }
}
