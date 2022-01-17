<?php

namespace Tests\Feature;

use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Storage;
use App\Events\UserCreated;
use App\Listeners\GenerateUserAvatar;
use App\Model\User;
use Tests\TestCase;
class UserRegistrationTest extends TestCase
{
    // I'm aware of the rule that every test should be independent and test maximum 1 funcionality
    // But I don't care, it's not some religion, I'm gonna test multiple functionalities that are related/similar to each other.
    /** @test */
    public function generates_an_avatar_on_user_creation_and_deletes_avatar_on_user_deletion()
    {
        $userFactory = $this->app->make('App\Services\Factories\UserFactory');
        $userFactory->override(array('name' => 'John Smith'));
        $userFactory->setParameters(accountType: 'CUSTOMER');
        
        $user = $userFactory->create();
        
        $storageService = $this->app->make('App\Services\StorageService');

        $expectedSvg = $storageService->getFile('fixtures', 'exampleAvatar.svg');
        $userSvg = $storageService->getFile('avatars', $user->avatar_path);

        $this->assertEquals($userSvg, $expectedSvg);

        $userService = $this->app->make('App\Services\UserService');

        $userService->delete($user);

        $this->expectException(FileNotFoundException::class);
        $storageService->getFile('avatars', $user->avatar_path);
    }
}
