<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Spa;
use App\Models\Services;

class ServicesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void {
        $this->clearPictures();

        Services::factory()
            ->count(1)
            ->create()
            ->each(function ($services) {
                $owner = User::where('roles', 'OWNER')->inRandomOrder()->first();
                $spa = User::where('roles', 'OWNER')->inRandomOrder()->first();
                $services->update([
                    'owner_id' => $owner->id,
                    'spa_id' => $spa->id
                ]);
            });
    }

    public function clearPictures() {
        $folderPath = base_path().'/public/fileupload/services';

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
