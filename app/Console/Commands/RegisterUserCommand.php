<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class RegisterUserCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:register {name} {email} {password}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Registers a new user from given data';

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
    public function handle()
    {
        $name = $this->argument('name');
        $email = $this->argument('email');
        $raw_password = $this->argument('password');

        if (empty($name) || empty($email) || empty($raw_password)) {
            $this->error('You must provide name, email and password.');
        }

        $user = User::where('email', $email)->first();

        if (! empty($user)) {
            $this->warn("The provide email {$email} is already in use.");
        }

        $password = Hash::make($raw_password);
        $user = User::create([
            'name' => $name,
            'email' => $email,
            'password' => $password
        ]);

        $this->info('User registered successfuly');

        return 0;
    }
}
