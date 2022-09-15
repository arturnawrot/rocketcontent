<?php

namespace Tests\Feature;

use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;
use App\Models\User;
use App\Repositories\Eloquent\UserRepository;

class CreateFirstAdminAccountTest extends TestCase
{
    /** @test */
    public function creates_first_admin_account()
    {
        Event::fake();

        $this->artisan('command:create-admin-account')
            ->expectsQuestion("What's your valid email address? (need to verify before you can log in)", 'test@admin.com')
            ->assertExitCode(0);

        $expectedAdmin = User::Where('email', 'test@admin.com')->firstOrFail();

        $this->assertSame($expectedAdmin->isAdmin(), True);
    }

    /** @test */
    public function returns_an_error_if_admin_account_already_exists()
    {
        Event::fake();

        $adminFactory = $this->app->make(\App\Services\Factories\AdminFactory::class);
        $user = $adminFactory->create();

        $this->assertSame(UserRepository::getAdmins()->count(), 1);

        $this->artisan('command:create-admin-account')
            ->expectsOutput("Admin account already exists.")
            ->assertExitCode(-1);

        $expectedAdmin = User::Where('email', 'test@admin.com')->first();

        $this->assertSame($expectedAdmin, null);
        
        $this->assertSame(UserRepository::getAdmins()->count(), 1);
    }
}
