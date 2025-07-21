<?php

namespace App\Http\Controllers\Ecommerce;

use App\Http\Controllers\Controller;
use App\Models\Option;
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
        $options = Option::pluck('value', 'key');
        return view('ecommerce.productos',[
            'productos' => $productos,
            'options' => $options,
        ]);
    }

    public function categorias(){
        $options = Option::pluck('value', 'key');
        return view('ecommerce.categorias', [
            'options' => $options,
        ]);
    }
}
