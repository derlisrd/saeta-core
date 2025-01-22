<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class RucParaguayService{
    public function __construct()
    {
        
    }

    public function infoRuc($ruc)
    {
        $url = env('URL_API_RUC_PARAGUAY');
        $url = $url . "/contribuyente" . "/".$ruc;
        $res = Http::get($url);
        $json = $res->json();
        // aqui modelar
        $data = (object) $json['data'];
        $info = [
            'doc'=> $data->doc,
            'nombre' => $data->razonSocial,
            'ruc' => $data->ruc,
            'estado'=>$data->estado,
            'juridico'=>$data->esPersonaJuridica ? 1 : 0
        ];
        // aqui modelar
        return $info;
    }
}