<?php

namespace App\Http\Controllers\Ecommerce;

use App\Http\Controllers\Controller;
use App\Models\Option;
use App\Models\Producto;
use Illuminate\Http\Request;


class HomeController extends Controller
{
    public function index()
    {
        $products = Producto::with('images');
        $products = $products->where('disponible', 1)->get();
        $options = Option::pluck('value', 'key');

        return view('ecommerce.index', [
            'productos' => $products,
            'options' => $options
        ]);
    }

    public function details(Request $req, $id)
    {
        $producto = Producto::where('id', $id)->with('images')->first();
        $options = Option::pluck('value', 'key');
        return view('ecommerce.details', ['producto' => $producto, 'options' => $options]);
    }

    public function contacto (){
        $options = Option::pluck('value', 'key');
        return view('ecommerce.contacto', ['options' => $options]);
    }
}
