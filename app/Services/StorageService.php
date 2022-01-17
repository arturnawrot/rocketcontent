<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;

class StorageService {
    private function getLocalDriver(string $type) {
        switch($type) {
            case 'avatars':
                $root = public_path('avatars');
                break;
            case 'storage':
                $root = storage_path('app');
                break;
            default:
                throw new \Exception("{$type} is not associated with any of available local drivers.");
        }

        return Storage::build([
            'driver' => 'local',
            'root' => $root
        ]);
    }

    public function getFile(string $driverType, string $fileName) {
        return $this->getLocalDriver($driverType)->get($fileName);
    }
}