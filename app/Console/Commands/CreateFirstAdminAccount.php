<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Repositories\Eloquent\UserRepository;
use App\Services\Factories\AdminFactory;

class CreateFirstAdminAccount extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:create-admin-account';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates the first admin account with temporary login and password';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(AdminFactory $adminFactory)
    {
        if(UserRepository::getAdmins()->count() > 0) {
            $this->error('Admin account already exists.');
            return -1;
        }

        $login = $this->ask("What's your valid email address? (need to verify before you can log in)");
        $password = $adminFactory->getProperty('password');

        $adminFactory->override(array('email' => $login));
        $adminFactory->create();

        $this->info('Admin account created.' . "\nLogin: $login\nPassword: $password\n");

        return 0;
    }
}
