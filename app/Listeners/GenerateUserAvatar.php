<?php

namespace App\Listeners;

use App\Events\UserCreated;
use App\Services\GenerateAvatar;
use App\Services\StorageService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class GenerateUserAvatar
{

    private $generateAvatarService;

    private $storageService;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(GenerateAvatar $generateAvatarService, StorageService $storageService)
    {
        $this->generateAvatarService = $generateAvatarService;

        $this->storageService = $storageService;
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\UserCreated  $event
     * @return void
     */
    public function handle(UserCreated $event)
    {
        $user = $event->user;
        
        $avatarSvg = $this->generateAvatarService->createAvatar($user);
        
        $randomStr = Str::random() . '.svg';

        $this->storageService->putFile('avatars', $randomStr, $avatarSvg);

        $user->avatar_path = $randomStr;
        $user->save();
    }
}
