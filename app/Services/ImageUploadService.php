<?php

namespace App\Services;


use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;



class ImageUploadService
{
    private ImageManager $manager;

    public function __construct()
    {
        // Crear el manager con el driver GD (o Imagick si lo prefieres)
        $this->manager = new ImageManager(new Driver());
    }
    
    public function subir(UploadedFile $image, int $id, string $directoryBase = 'img'): string
    {
        try {
            // Validar que la extensión sea permitida
            $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
            $originalExtension = strtolower($image->getClientOriginalExtension());
            
            if (!in_array($originalExtension, $allowedExtensions)) {
                throw new \Exception("Formato de imagen no permitido: {$originalExtension}");
            }

            // Define la carpeta basada en el ID del producto
            $directory = "{$directoryBase}/{$id}";
            $randomNumber = rand(1, 1000);
            
            // Cambiar extensión a .webp
            $filename = time() . $randomNumber . '.webp';
            $fullPath = $directory . '/' . $filename;

            // Crear el directorio si no existe
            $storagePath = storage_path('app/public/' . $directory);
            if (!file_exists($storagePath)) {
                mkdir($storagePath, 0755, true);
            }

            // Procesar y convertir la imagen a WebP (Intervention Image v3)
            $image = $this->manager->read($image->getRealPath());
            
            // Redimensionar manteniendo proporción (máximo 1200px en cualquier lado)
            $image->scaleDown(width: 1200, height: 1200);
            
            // Convertir a WebP y obtener los datos
            $webpData = $image->toWebp(quality: 85);

            // Guardar la imagen procesada
            Storage::disk('public')->put($fullPath, $webpData);

            // Retorna la URL pública de la imagen
            return asset('storage/' . $fullPath);

        } catch (\Throwable $th) {
            Log::error('Error al subir imagen: ' . $th->getMessage(), [
                'file' => $th->getFile(),
                'line' => $th->getLine(),
                'product_id' => $id
            ]);
            throw $th;
        }
    }





   /*  public function subir(UploadedFile $image, int $id, string $directoryBase = 'img'): string
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
    } */


}
