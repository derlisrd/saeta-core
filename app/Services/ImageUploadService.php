<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;

class ImageUploadService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function subir(UploadedFile $image, int $id, string $directoryBase = 'public'): string
    {
        // Define la carpeta basada en el ID del producto
        $directory = "{$directoryBase}/{$id}";

        // Nombre de la imagen con la marca de tiempo
        $filename = time() . '.' . $image->getClientOriginalExtension();

        // Guarda la imagen en storage/app/public/{id}/timestamp.jpg
        $path = $image->storeAs($directory, $filename, 'public');

        // Retorna la URL pública de la imagen
        return asset('storage/' . $path);
    }
}
