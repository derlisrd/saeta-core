<?php

namespace App\Http\Controllers\Ecommerce;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Option;
use App\Models\Producto;
use Illuminate\Http\Request;

class ProductosController extends Controller
{
    public function productos()
    {
        $productos = Producto::where('disponible', 1)
            ->where('tipo', 1)
            ->with(['category', 'images'])
            ->select('id', 'nombre', 'codigo', 'precio_normal', 'descripcion', 'disponible', 'precio_descuento', 'descuento_activo', 'tipo', 'precio_minimo', 'category_id')
            ->get();
        $options = Option::pluck('value', 'key');
        return view('ecommerce.productos', [
            'productos' => $productos,
            'options' => $options,
        ]);
    }

    public function categorias()
    {
        $options = Option::pluck('value', 'key');
        $categorias = Category::where('publicado', 1)->with(['productos' => function ($query) {
                $query->where('disponible', 1)
                    ->with(['images' => function ($query) {
                        // Solo selecciona la URL y el product_id de la primera imagen
                        $query->select('id', 'producto_id', 'miniatura')->orderBy('id')->limit(1);
                    }]);
            }])->get();

        return view('ecommerce.categorias', [
            'options' => $options,
            'categorias' => $categorias
        ]);
    }

    public function productosPorCategorias($id){
        $options = Option::pluck('value', 'key');
        $producto = Producto::where('category_id', $id)->get();

        return view('ecommerce.categorias.productos', [
            'options' => $options,
            'productos' => $producto
        ]);

    }
}
