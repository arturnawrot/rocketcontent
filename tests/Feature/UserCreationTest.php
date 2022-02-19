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
    protected $storageService;

    public function setUp() : void
    {
        parent::setUp();

        $this->storageService = $this->app->make(\App\Services\StorageService::class);
    }

    /** @test */
    public function generates_an_avatar_on_user_creation()
    {
        Storage::fake('avatars');
        
        Event::fake();

        $customerFactory = $this->app->make(\App\Services\Factories\CustomerFactory::class);
        $customerFactory->override(array('name' => 'John Smith'));
        
        $customer = $customerFactory->create();

        $event = \Mockery::mock(UserCreated::class);
        $event->user = $customer;

        $listener = $this->app->make(GenerateUserAvatar::class);
        $listener->handle($event);
        
        $expectedSvg = $this->storageService->getFile('fixtures', 'exampleAvatar.svg');
        $customerSvg = $this->storageService->getFile('avatars', $customer->avatar_path);

        $this->assertEquals($customerSvg, $expectedSvg);

        $customerFactory->destroy();
    }

    /** @test */
    public function deletes_avatar_on_user_deletion()
    {
        Event::fake();

        $customerFactory = $this->app->make(\App\Services\Factories\CustomerFactory::class);
        
        $customer = $customerFactory->create();

        $event = \Mockery::mock(UserCreated::class);
        $event->user = $customer;

        $listener = $this->app->make(GenerateUserAvatar::class);
        $listener->handle($event);

        $event = \Mockery::mock(UserDeleting::class);
        $event->user = $customer;

        $listener = $this->app->make(DeleteUserAvatar::class);
        $listener->handle($event);

        $customerFactory->destroy();

        $this->expectException(FileNotFoundException::class);

        $this->storageService->getFile('avatars', $customer->avatar_path);
    }
}
