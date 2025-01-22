<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class RucParaguayService{
    public function __construct()
    {
        
    }

    public function infoRuc($ruc)
    {
        $apikey = env('API_KEY_RUC_PARAGUAY');
        $url = env('URL_API_RUC_PARAGUAY');
        $url = $url . '/' .$ruc;
        $res = Http::get($url);
        $json = $res->json();
        // aqui modelar
        $data = (object) $json['data'];
        return $this->dto($data);
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