<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class CreateUserWithRole extends Command
{
    protected $signature = 'user:create {name} {email} {password} {role}';

    protected $description = 'Create a new user and assign a single role';

    public function handle()
    {
        $name = $this->argument('name');
        $email = $this->argument('email');
        $password = $this->argument('password');
        $role = $this->argument('role');

        if (User::where('email', $email)->exists()) {
            $this->error('A user with this email already exists.');

            return 1;
        }

        $user = User::create([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($password),
        ]);

        $roleModel = Role::firstOrCreate(['name' => $role]);
        $user->assignRole($roleModel);

        $this->info("User {$name} <{$email}> created successfully.");
        $this->info('Role assigned: '.$role);

        return 0;
    }
}
