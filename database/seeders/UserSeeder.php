<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         // Create 5 users with the 'admin' role
         User::factory()
         ->count(1)
         ->state([
            'roles' => 'ADMIN',
            'email' => 'admin@gmail.com'
        ])
         ->create();

        // Create 5 admins with the 'spa_owner' role
        User::factory()
            ->count(2)
            ->state(['roles' => 'OWNER'])
            ->create();

        User::factory()
            ->count(10)
            ->state(['roles' => 'THERAPIST'])
            ->create()
            ->each(function ($user) {
                $owner = User::where('roles', 'OWNER')->inRandomOrder()->first();
                $user->update(['owner_id' => $owner->id]);
            });;

        User::factory()
            ->count(1)
            ->state([
                'roles' => 'CLIENT',
                'email' => 'client@gmail.com'
            ])
            ->create();    
    }
}
