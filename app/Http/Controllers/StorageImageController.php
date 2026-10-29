<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;

class StorageImageController extends Controller
{
    public function show(string $path)
    {
        // Sanitizar path traversal
        $path = ltrim(str_replace(['..', '\\'], '', $path), '/');

        $disk = Storage::disk('public');

        if (!$disk->exists($path)) {
            abort(404);
        }

        // path() devuelve la ruta absoluta en el sistema de archivos
        $fullPath = $disk->path($path);

        if (!is_file($fullPath)) {
            abort(404);
        }

        // response()->file() detecta el MIME automáticamente y existe en todas las versiones
        return response()->file($fullPath, [
            'Cache-Control' => 'public, max-age=86400',
        ]);
    }
}