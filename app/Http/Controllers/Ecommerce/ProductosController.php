<?php

namespace App\Http\Controllers\Ecommerce;

use App\Http\Controllers\Controller;
use App\Models\Producto;
use Illuminate\Http\Request;

class ProductosController extends Controller
{
    public function index(){
        $productos = Producto::where('disponible', 1)
        ->with('images')
        ->get();
        return response()->json([
            'success' => true,
            'results' => $productos
        ]);
    }
}
