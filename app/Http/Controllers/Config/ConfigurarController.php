<?php

namespace App\Http\Controllers\Config;

use App\Http\Controllers\Controller;
use App\Models\Empresa;
use Illuminate\Http\Request;

class ConfigurarController extends Controller
{
    public function verificar(){
        $empresa = Empresa::first();
        
            return response()->json([
                'success' => true,
                'results' => [
                    'configurado' => $empresa->configurado
                ]
            ]);
        
    }

    public function configurar(){
        $empresa = Empresa::first();
        $empresa->configurado = 1;
        $empresa->save();

        return response()->json([
            'success' => true,
            'message' => 'Empresa configurada correctamente'
        ]);
    }
}
