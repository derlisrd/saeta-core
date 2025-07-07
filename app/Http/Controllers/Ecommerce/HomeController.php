<?php

namespace App\Http\Controllers\Ecommerce;

use App\Http\Controllers\Controller;
use App\Models\Empresa;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class HomeController extends Controller
{
    public function index(){
        $products = Producto::with('images');
        $products = $products->where('disponible', 1)->get();
        $nombreTienda = Empresa::find(1);

        return view('ecommerce.index',['productos'=>$products, 'nombreTienda'=>$nombreTienda->nombre]);
    }
}
