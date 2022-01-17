<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Event;
use App\Events\UserCreated;
use App\Listeners\GenerateUserAvatar;
use App\Model\User;
use Tests\TestCase;

class UserRegistrationTest extends TestCase
{
    /** @test */
    public function generates_an_avatar_on_user_creation()
    {
        $userFactory = $this->app->make('App\Services\Factories\UserFactory');
        $userFactory->override(array('name' => 'John Smith'));
        $userFactory->setParameters(accountType: 'CUSTOMER');
        
        $user = $userFactory->create();
        
        $storageService = $this->app->make('App\Services\StorageService');

        $expectedSvg = $storageService->getFile('storage', 'fixtures/exampleAvatar.svg');
        $userSvg = $storageService->getFile('avatars', $user->avatar_path);

        $this->assertEquals($userSvg, $expectedSvg);
    }
}
