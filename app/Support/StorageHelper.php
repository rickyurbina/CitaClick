<?php

namespace App\Support;

class StorageHelper
{
    /**
     * Normaliza una ruta de storage a un formato limpio y consistente.
     * Acepta URLs completas, paths con prefijos (storage/, public/), slashes
     * duplicados, etc.
     */
    public static function path(?string $path): ?string
    {
        if (!$path) {
            return null;
        }

        // Si es URL completa, extraer solo el path
        if (filter_var($path, FILTER_VALIDATE_URL)) {
            $parsed = parse_url($path, PHP_URL_PATH) ?: '';
            $path = $parsed;
        }

        // Normalizar slashes (Windows)
        $path = str_replace('\\', '/', $path);

        // Quitar prefijos repetidos: /storage/, storage/, public/, etc.
        $path = preg_replace('#^/?(storage/|public/)+#i', '', $path);

        // Quitar slashes iniciales/finales
        $path = trim($path, '/');

        return $path !== '' ? $path : null;
    }

    /**
     * Devuelve la URL pública para una ruta de storage.
     *
     * Usa el controlador /media/ (siempre funciona, sin depender de symlinks
     * ni permisos del web server). Compatible con Docker, Windows, Linux,
     * hosting compartido, etc.
     */
    public static function url(?string $path): ?string
    {
        $clean = self::path($path);
        if (!$clean) {
            return null;
        }

        return url('media/' . $clean);
    }
}