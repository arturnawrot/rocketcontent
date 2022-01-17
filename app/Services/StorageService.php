<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;

class StorageService {
    private static function getLocalDriver(string $type) {
        return Storage::disk($type);
    }

    public function getFile(string $driverType, string $fileName) {
        return self::getLocalDriver($driverType)->get($fileName);
    }

    public function deleteFile(string $driverType, string $fileName) {
        return self::getLocalDriver($driverType)->delete($fileName);
    }

    public function putFile(string $driverType, string $fileName, $content) {
        return self::getLocalDriver($driverType)->put($fileName, $content);
    }

    public static function getFileUrl(string $driverType, string $fileName) {
        return self::getLocalDriver($driverType)->url($fileName);
    }
}