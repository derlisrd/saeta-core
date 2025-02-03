<?php

namespace App\Http\Controllers\Factura;

use App\Http\Controllers\Controller;
use App\Models\Moneda;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MonedaController extends Controller
{
    public function index()
    {
        $results = Moneda::all();
        return response()->json([
            'success' => true,
            'data' => $results
        ]);
    }

    public function store(Request $req){
        $validator = Validator::make($req->all(), [
            'nombre' => 'required',
            'simbolo' => 'required',
            'default' => 'required'
        ]);

        if ($validator->fails())
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first()
            ], 400);

        if($req->default == 1)
            Moneda::where('default', 1)->update(['default' => 0]);
        
        $results = Moneda::create($req->all());
        return response()->json([
            'success' => true,
            'results' => $results
        ]);
    }
    public function update(Request $req, $id){
        $validator = Validator::make($req->all(), [
            'nombre' => 'required',
            'simbolo' => 'required',
            'default' => 'required'
        ]);

        if ($validator->fails())
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first()
            ], 400);

        if($req->default == 1)
            Moneda::where('default', 1)->update(['default' => 0]);
        
        $results = Moneda::find($id);
        $results->update($req->all());
        return response()->json([
            'success' => true,
            'results' => $results
        ]);
    }
}
