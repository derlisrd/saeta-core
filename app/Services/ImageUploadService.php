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

            // Define la carpeta basada en el ID del producto (relativa al disco público del tenant)
            $directory = "{$directoryBase}/{$id}";
            $randomNumber = rand(1, 1000);

            // Cambiar extensión a .webp
            $filename = time() . $randomNumber . '.webp';
            $fullPath = $directory . '/' . $filename; // Esta es la ruta RELATIVA al disco 'public' del tenant

            // NO ES NECESARIO mkdir() aquí. Storage::disk('public')->put() creará los directorios
            // automáticamente dentro del scope del tenant.
            // $storagePath = storage_path('app/public/' . $directory);
            // if (!file_exists($storagePath)) {
            //     mkdir($storagePath, 0755, true);
            // }

            // Procesar y convertir la imagen a WebP (Intervention Image v3)
            $imageProcessor = $this->manager->read($image->getRealPath());

            // Redimensionar manteniendo proporción (máximo 1200px en cualquier lado)
            $imageProcessor->scaleDown(width: 1200, height: 1200);

            // Convertir a WebP y obtener los datos
            $webpData = $imageProcessor->toWebp(quality: 85);

            // Guardar la imagen procesada usando el disco 'public' (que es tenant-aware)
            Storage::disk('public')->put($fullPath, $webpData);

            // Retorna la URL pública de la imagen. asset() es tenant-aware si 'asset_helper_tenancy' está en true.
            return asset('storage/' . $fullPath);

        } catch (\Throwable $th) {
            Log::error('Error al subir imagen: ' . $th->getMessage(), [
                'file' => $th->getFile(),
                'line' => $th->getLine(),
                'product_id' => $id,
                'trace' => $th->getTraceAsString(), // Añadir el trace para mejor depuración
            ]);
            throw $th;
        }
    }

    public function crearMiniaturaCuadrada(UploadedFile $image, int $id, string $directoryBase = 'img', int $size = 200): string
    {
        try {
            // Define la carpeta basada en el ID del producto (relativa al disco público del tenant)
            $directory = "{$directoryBase}/{$id}";
            $randomNumber = rand(1, 1000);

            // Cambiar extensión a .webp
            $filename = time() . $randomNumber . '_thumb.webp';
            $fullPath = $directory . '/' . $filename; // Ruta RELATIVA al disco 'public' del tenant

            // NO ES NECESARIO mkdir() aquí. Storage::disk('public')->put() creará los directorios
            // automáticamente dentro del scope del tenant.
            // $storagePath = storage_path('app/public/' . $directory);
            // if (!file_exists($storagePath)) {
            //     mkdir($storagePath, 0755, true);
            // }

            // Procesar imagen: recorte cuadrado centrado
            $processedImage = $this->manager->read($image->getRealPath())
                ->cover(width: $size, height: $size) // Recorte cuadrado centrado
                ->toWebp(quality: 80);

            // Guardar la imagen procesada usando el disco 'public' (que es tenant-aware)
            Storage::disk('public')->put($fullPath, $processedImage);
            return asset('storage/' . $fullPath);

        } catch (\Throwable $th) {
            Log::error('Error al crear miniatura cuadrada: ' . $th->getMessage(), [
                'file' => $th->getFile(),
                'line' => $th->getLine(),
                'product_id' => $id,
                'trace' => $th->getTraceAsString(),
            ]);
            throw $th;
        }
    }

    public function eliminar(string $url): bool
    {
        try {
           
            // ya que el disco ya está scopeado.
            $path = str_replace(asset('storage/'), '', $url);

            $parsedUrl = parse_url($url);
            $relativePath = ltrim($parsedUrl['path'], '/'); // Elimina la barra inicial

            // Quita 'storage/' del inicio de la ruta
            if (str_starts_with($relativePath, 'storage/')) {
                $relativePath = substr($relativePath, strlen('storage/'));
            }

            $pathToDelete = str_replace('storage/', '', $path); // Elimina solo 'storage/' del inicio

            $pathToDelete = str_replace(asset('storage/'), '', $url);

            return Storage::disk('public')->delete($pathToDelete);

        } catch (\Throwable $th) {
            Log::error('Error al eliminar imagen: ' . $th->getMessage(), [
                'url' => $url,
                'file' => $th->getFile(),
                'line' => $th->getLine(),
                'trace' => $th->getTraceAsString(),
            ]);
            return false;
        }
    }


}
