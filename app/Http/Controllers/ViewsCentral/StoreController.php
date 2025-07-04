<?php

namespace App\Http\Controllers\ViewsCentral;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class StoreController extends Controller
{
    public function create(){
        return view('central.storecreated');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'store_name' => 'required|string|max:255|unique:stores,name', // Asume que el nombre de la tienda debe ser único
        ], [
            'store_name.required' => 'El nombre de la tienda es obligatorio.',
            'store_name.unique' => 'Este nombre de tienda ya está en uso. Por favor, elige otro.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                             ->withErrors($validator)
                             ->withInput();
        }

        try {
            // Crea una nueva tienda asociada al usuario autenticado
            // Asume que tienes una relación User hasOne Store o User hasMany Stores
            

            return redirect()->route('home')->with('success', '¡Tu tienda ha sido creada exitosamente!'); // Redirige al dashboard o a la página principal de la tienda

        } catch (\Exception $e) {
            Log::error('Error al crear la tienda: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Hubo un error al crear tu tienda. Por favor, inténtalo de nuevo.');
        }
    }

}
