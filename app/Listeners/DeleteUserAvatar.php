<?php

namespace App\Listeners;

use App\Events\UserDeleting;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Services\StorageService;

class DeleteUserAvatar
{

    private $storageService;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(StorageService $storageService)
    {
        $this->storageService = $storageService;
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\UserCreated  $event
     * @return void
     */
    public function handle(UserDeleting $event)
    {
        $user = $event->user;
        
        $this->storageService->deleteFile('avatars', $user->avatar_path);
    }
}
