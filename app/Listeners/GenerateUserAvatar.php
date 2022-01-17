<?php

namespace App\Listeners;

use App\Events\UserCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Services\GenerateAvatar;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class GenerateUserAvatar
{

    private $generateAvatarService;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(GenerateAvatar $generateAvatarService)
    {
        $this->generateAvatarService = $generateAvatarService;
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

        $disk = Storage::build([
            'driver' => 'local',
            'root' => public_path('avatars'),
        ]);
        
        $randomStr = Str::random() . '.svg';

        $disk->put($randomStr, $avatarSvg);

        $user->avatar_path = $randomStr;
        $user->save();
    }
}
