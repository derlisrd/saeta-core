<?php

namespace App\Http\Controllers\Ecommerce;

use App\Http\Controllers\Controller;
use App\Models\Option;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OptionsController extends Controller
{

    public function find($key){
        $option = Option::where('key', $key)->first();
        return response()->json([
            'success'=>true,
            'option' => $option
        ]);
    }

    public function store(Request $req){
        $validator = Validator::make($req->all(), [
            'key' => 'required',
            'value' => 'required',
        ]);
        if ($validator->fails()) 
            return response()->json([
                'success'=>false,
                'message' => $validator->errors()->first(),
            ], 400);
        
        Option::updateOrInsert(
            ['key' => $req->key],
            ['value'=>$req->value]
        );

        return response()->json([
            'success'=>true,
            'message' => 'Options updated successfully'
        ]);

    }
}
