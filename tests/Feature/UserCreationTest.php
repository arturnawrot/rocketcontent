<?php

namespace Tests\Feature;

use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Event;
use App\Listeners\GenerateUserAvatar;
use App\Listeners\DeleteUserAvatar;
use App\Events\UserDeleting;
use App\Events\UserCreated;
use App\Model\User;
use Tests\TestCase;

class UserCreationTest extends TestCase
{
    protected $userService;

    protected $storageService;

    public function setUp() : void
    {
        parent::setUp();

        $this->userService = $this->app->make(\App\Services\UserService::class);
        $this->storageService = $this->app->make(\App\Services\StorageService::class);
    }

    /** @test */
    public function generates_an_avatar_on_user_creation()
    {
        Storage::fake('avatars');
        
        Event::fake();

        $userFactory = $this->app->make(\App\Services\Factories\CustomerFactory::class);
        $userFactory->override(array('name' => 'John Smith'));
        
        $user = $userFactory->create();

        $event = \Mockery::mock(UserCreated::class);
        $event->user = $user;

        $listener = $this->app->make(GenerateUserAvatar::class);
        $listener->handle($event);
        
        $expectedSvg = $this->storageService->getFile('fixtures', 'exampleAvatar.svg');
        $userSvg = $this->storageService->getFile('avatars', $user->avatar_path);

        $this->assertEquals($userSvg, $expectedSvg);
    }

    /** @test */
    public function deletes_avatar_on_user_deletion()
    {
        Event::fake();

        $userFactory = $this->app->make(\App\Services\Factories\CustomerFactory::class);
        
        $user = $userFactory->create();

        $event = \Mockery::mock(UserCreated::class);
        $event->user = $user;

        $listener = $this->app->make(GenerateUserAvatar::class);
        $listener->handle($event);

        $event = \Mockery::mock(UserDeleting::class);
        $event->user = $user;

        $listener = $this->app->make(DeleteUserAvatar::class);
        $listener->handle($event);

        $this->userService->delete($user);

        $this->expectException(FileNotFoundException::class);

        $this->storageService->getFile('avatars', $user->avatar_path);
    }
}
