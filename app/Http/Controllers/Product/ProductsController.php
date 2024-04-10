<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    public function index(){
        return response()->json([
            'success'=>true,
            'results'=>Product::all()
        ]);
    }
}
