<?php

namespace App\Http\Controllers\Producto;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoriasController extends Controller
{
    public function index(){
        $categorias = Category::all();
        return response()->json([
            'success' => true,
            'results' => $categorias
        ]);
    }
}
