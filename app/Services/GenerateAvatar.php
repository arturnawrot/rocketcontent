<?php

namespace App\Services;

use App\Models\User;
use Laravolt\Avatar\Avatar;
use Illuminate\Support\Facades\App;

class GenerateAvatar {
    public function createAvatar(User $user) {
        $avatar = new Avatar(config('laravolt.avatar'));
        return $avatar->create($user->name)->setTheme($this->getTheme())->toSvg();
    }

    public function getTheme() {
        if(App::runningUnitTests()) {
            return 'testing';
        }

        return 'colorful';
    }
}