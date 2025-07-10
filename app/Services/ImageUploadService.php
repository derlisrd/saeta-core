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
            $fullPath = $directory . '/' . $filename;

            // Procesar y convertir la imagen a WebP (Intervention Image v3)
            $imageProcessor = $this->manager->read($image->getRealPath());

            // Redimensionar manteniendo proporción (máximo 1200px en cualquier lado)
            $imageProcessor->scaleDown(width: 1200, height: 1200);

            // Convertir a WebP y obtener los datos
            $webpData = $imageProcessor->toWebp(quality: 85);

            // Guardar la imagen procesada usando el disco 'public' (que es tenant-aware)
            Storage::disk('public')->put($fullPath, $webpData);

            // Construir URL manualmente
            return $this->buildRelativePath($fullPath);

        } catch (\Throwable $th) {
            Log::error('Error al subir imagen: ' . $th->getMessage(), [
                'file' => $th->getFile(),
                'line' => $th->getLine(),
                'product_id' => $id,
                'trace' => $th->getTraceAsString(),
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
            $fullPath = $directory . '/' . $filename;

            // Procesar imagen: recorte cuadrado centrado
            $processedImage = $this->manager->read($image->getRealPath())
                ->cover(width: $size, height: $size) // Recorte cuadrado centrado
                ->toWebp(quality: 80);

            // Guardar la imagen procesada usando el disco 'public' (que es tenant-aware)
            Storage::disk('public')->put($fullPath, $processedImage);
            
            // Usar el mismo método para construir la URL
            return $this->buildRelativePath($fullPath);

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
            // Extraer la ruta relativa desde la URL
            $parsedUrl = parse_url($url);
            $relativePath = ltrim($parsedUrl['path'], '/');

            // Quitar 'storage/' del inicio de la ruta si existe
            if (str_starts_with($relativePath, 'storage/')) {
                $relativePath = substr($relativePath, strlen('storage/'));
            }

            // Eliminar usando Storage con la ruta relativa
            return Storage::disk('public')->delete($relativePath);

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

    private function buildRelativePath(string $path): string
    {
        // Asegurar que el enlace simbólico existe
        $this->ensureStorageLink();
        
        // Retornar solo la ruta relativa comenzando con /storage/
        return '/storage/' . ltrim($path, '/');
    }

    /**
     * Construye la URL completa para acceder a la imagen desde el tenant
     */
    private function buildTenantUrl(string $path): string
    {
        // Asegurar que el enlace simbólico existe
        $this->ensureStorageLink();
        
        // Obtener la URL base del request actual
        $baseUrl = request()->getSchemeAndHttpHost();
        
        // Construir la URL usando la ruta estándar /storage/
        return $baseUrl . '/storage/' . ltrim($path, '/');
    }

    /**
     * Verifica y crea el enlace simbólico del storage si no existe
     */
    private function ensureStorageLink(): void
    {
        $tenant = tenant();
        
        if (!$tenant) {
            return; // No hay tenant activo
        }
        
        $tenantStoragePath = storage_path("app/public");
        $tenantPublicPath = public_path('storage');
        
        // Verificar que el directorio de storage existe
        if (!file_exists($tenantStoragePath)) {
            mkdir($tenantStoragePath, 0755, true);
        }
        
        // Crear el enlace simbólico si no existe
        if (!file_exists($tenantPublicPath)) {
            try {
                symlink($tenantStoragePath, $tenantPublicPath);
                Log::info("Enlace simbólico creado para tenant: {$tenant->id}");
            } catch (\Exception $e) {
                Log::error("Error al crear enlace simbólico para tenant {$tenant->id}: " . $e->getMessage());
            }
        }
    }
}