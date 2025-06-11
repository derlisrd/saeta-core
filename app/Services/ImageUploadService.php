<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;

class ImageUploadService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function subir(UploadedFile $image, int $id, string $directoryBase = 'img'): string
    {
        try {
            // Define la carpeta basada en el ID del producto
        $directory = "{$directoryBase}/{$id}";
        $randomNumer = rand(1, 1000);
        // Nombre de la imagen con la marca de tiempo
        $filename = time() . $randomNumer . '.' . $image->getClientOriginalExtension();

        // Guarda la imagen en storage/app/public/{id}/timestamp.jpg
        $path = $image->storeAs($directory, $filename, 'public');

        // Retorna la URL pública de la imagen
        return asset('storage/' . $path);
        } catch (\Throwable $th) {
            Log::error($th);
            throw $th;
        }
    }
}
