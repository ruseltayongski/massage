<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Spa;
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
            'email' => 'admin@gmail.com',
        ])
        ->withRoles('admin')
        ->create();

        User::factory()
         ->count(1)
         ->state([
             'roles' => 'OWNER',
             'email' => 'owner@gmail.com',
         ])
         ->withRoles('owner')
         ->create();

        $this->call(SpaSeeder::class);

        User::factory()
            ->count(20)
            ->state([
                'roles' => 'THERAPIST'
            ])
            ->withRoles('therapist')
            ->create()
            ->each(function ($user) {
                $owner = User::where('roles', 'OWNER')->inRandomOrder()->first();
                $spa = Spa::where('owner_id', $owner->id)->inRandomOrder()->first();
                $user->update([
                    'owner_id' => $owner->id,
                    'spa_id' => $spa->id
                ]);
            });

        User::factory()
            ->count(1)
            ->state([
                'roles' => 'CLIENT',
                'email' => 'client@gmail.com'
            ])
            ->withRoles('client')
            ->create();    
    }

    public function clearPictures() {
        $directory = ['admin','owner','therapist','client'];

        foreach($directory as $dir) {
            $folderPath = base_path().'/public/fileupload/'.$dir.'/profile';
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
}
