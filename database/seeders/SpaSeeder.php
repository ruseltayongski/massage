<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Spa;
use App\Models\User;

class SpaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->clearPictures();

        Spa::factory()
            ->count(2)
            ->create()
            ->each(function ($spa) {
                $owner = User::where('roles', 'OWNER')->inRandomOrder()->first();
                $spa->update(['owner_id' => $owner->id]);
            });
    }

    public function clearPictures() {
        $folderPath = base_path().'/public/fileupload/spa';

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
