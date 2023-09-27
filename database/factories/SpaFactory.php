<?php

namespace Database\Factories;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Spa>
 */
class SpaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $response = Http::get('https://placebeard.it/255x366');
        if ($response->successful()) {
            $image = $response->body();

            $filename = fake()->firstName().'.jpg';
            $spa_picture_path = '/fileupload/spa/'.$filename;
            file_put_contents(base_path().'/public'.$spa_picture_path, $image);

            return [
                'name' => fake()->company(),
                'description' => fake()->catchPhrase(),
                'picture' => $filename,
                'remember_token' => Str::random(10),
            ];
        }
    }
}
