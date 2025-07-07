<?php

namespace App\Http\Controllers\Ecommerce;

use App\Http\Controllers\Controller;
use App\Models\Producto;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(){
        $products = Producto::all();
        return view('ecommerce.index',['productos',$products]);
    }
}
