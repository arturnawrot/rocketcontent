<?php

namespace App\Services;

use App\Models\User;
use Laravolt\Avatar\Avatar;

class GenerateAvatar {
    public function createAvatar(User $user) {
        $avatar = new Avatar(config('laravolt.avatar'));
        return $avatar->create($user->name)->setTheme('colorful')->toSvg();
    }
}