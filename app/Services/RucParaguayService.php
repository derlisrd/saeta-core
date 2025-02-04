<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class RucParaguayService{
    public function __construct()
    {
        
    }

    public function infoRuc($ruc)
    {
        try {
            $url = env('URL_API_RUC_PARAGUAY');
            $url = $url . '/' .$ruc;
            $res = Http::get($url);
            $json = $res->json();
            // aqui modelar
            $data = (object) $json['data'];
            return $this->dto($data);
        } catch (\Throwable $th) {
            return null;
        }
    }

    public function infoRuc2($doc){
        try {
            $url = env('URL_API_RUC_PARAGUAY_VARIABLE');
            $apiKey = env('API_KEY_RUC_PARAGUAY_VARIABLE');
            $res = Http::withHeaders([
                'Accept' => 'application/json',
                'Api-Key' => $apiKey
            ])->post($url, [
                'ruc' => $doc
            ]);

            $json = $res->json();
            // aqui modelar
            $data =(object) $json[0];
            return [
                'doc'=> $data->ruc,
                'nombre' => $data->nombre,
                'ruc' =>$data->ruc .'-'.$data->digito_verificador,
                'estado'=>$data->estado,
                'juridico'=> 0
            ];
        } catch (\Throwable $th) {
            Log::error('Error en infoRuc2: ' . $th->getMessage());
            return null;
        }
    }


    private function dto($data){
        return [
            'doc'=> $data->doc,
            'nombre' => $data->razonSocial,
            'ruc' => $data->ruc,
            'estado'=>$data->estado,
            'juridico'=>$data->esPersonaJuridica ? 1 : 0
        ];
    }
}