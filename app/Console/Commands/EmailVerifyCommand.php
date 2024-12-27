<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class EmailVerifyCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'users:emailverify';
    protected $description = 'Delete users whose email is not verified (email_verified_at is null)';
    public function handle()
    {
        $unverifiedUsers = User::whereNull('email_verified_at')->get();

        if ($unverifiedUsers->isEmpty()) {
            $this->info('No unverified users found.');
        } else {
            $this->info('Deleting unverified users...');

            foreach ($unverifiedUsers as $user) {
                $user->delete(); 
                $this->info("Deleted user: {$user->email}");
            }

            $this->info('Unverified users deleted successfully.');
        }
    }
}
