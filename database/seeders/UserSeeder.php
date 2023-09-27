<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Http;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->clearPictures();
        
         User::factory()
         ->count(1)
         ->state([
            'roles' => 'ADMIN',
            'email' => 'admin@gmail.com'
        ])
         ->create();

         User::factory()
         ->count(1)
         ->state([
             'roles' => 'OWNER',
             'email' => 'owner@gmail.com'
         ])
         ->create();

        User::factory()
            ->count(20)
            ->state(['roles' => 'THERAPIST'])
            ->create()
            ->each(function ($user) {
                $owner = User::where('roles', 'OWNER')->inRandomOrder()->first();
                $user->update(['owner_id' => $owner->id]);
            });

        User::factory()
            ->count(1)
            ->state([
                'roles' => 'CLIENT',
                'email' => 'client@gmail.com'
            ])
            ->create();    
    }

    public function clearPictures() {
        $folderPath = base_path().'/public/fileupload/owner';

        $allowedExtensions = ['jpg', 'png', 'gif']; 

        if ($handle = opendir($folderPath)) {
            while (false !== ($file = readdir($handle))) {
                if (is_file($folderPath . '/' . $file) && in_array(pathinfo($file, PATHINFO_EXTENSION), $allowedExtensions)) {
                    unlink($folderPath . '/' . $file);
                }
            }
            closedir($handle);
        }
    }
}
