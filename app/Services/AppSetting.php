<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class AppSetting
{
    private static ?array $memoryCache = null;

    private static function filePath(): string
    {
        return storage_path('app/settings.json');
    }

    public static function all(): array
    {
        if (self::$memoryCache !== null) {
            return self::$memoryCache;
        }

        $path = self::filePath();
        if (file_exists($path)) {
            try {
                $content = file_get_contents($path);
                $decoded = json_decode($content, true);
                if (is_array($decoded)) {
                    self::$memoryCache = $decoded;
                    return self::$memoryCache;
                }
            } catch (\Throwable $e) {
                Log::warning('AppSetting: Gagal membaca settings.json: ' . $e->getMessage());
            }
        }

        self::$memoryCache = [];
        return self::$memoryCache;
    }

    public static function get(string $key, mixed $default = null): mixed
    {
        $all = self::all();
        if (array_key_exists($key, $all) && $all[$key] !== null && $all[$key] !== '') {
            return $all[$key];
        }

        $cached = Cache::get($key);
        if ($cached !== null && $cached !== '') {
            return $cached;
        }

        return $default;
    }

    public static function set(string $key, mixed $value): void
    {
        self::setMany([$key => $value]);
    }

    public static function setMany(array $data): void
    {
        $all = self::all();
        foreach ($data as $key => $value) {
            $all[$key] = $value;
            Cache::forever($key, $value);
        }

        self::$memoryCache = $all;

        try {
            $path = self::filePath();
            $dir = dirname($path);
            if (! is_dir($dir)) {
                @mkdir($dir, 0775, true);
            }
            @file_put_contents($path, json_encode($all, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
        } catch (\Throwable $e) {
            Log::warning('AppSetting: Gagal menyimpan settings.json: ' . $e->getMessage());
        }
    }
}
