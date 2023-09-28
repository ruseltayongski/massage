<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Services>
 */
class ServicesFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $maxRetries = 3;
        $retryCount = 0;

        do {
            try {
                $response = Http::timeout(60)->get('https://placebeard.it/500x600');
            if ($response->successful()) {
                $image = $response->body();

                $filename = fake()->firstName().'.jpg';
                $services_picture_path = '/fileupload/services/'.$filename;
                file_put_contents(base_path().'/public'.$services_picture_path, $image);

                return [
                    'name' => fake()->company(),
                    'description' => fake()->catchPhrase(),
                    'price' => fake()->randomNumber(2),
                    'picture' => $filename,
                    'remember_token' => Str::random(10),
                ];
            }
            } catch (RequestException $e) {
                Log::error('cURL request timed out: ' . $e->getMessage());
                $retryCount++;
            }
        } while ($retryCount < $maxRetries);

        // Default return value in case of failure
        return [
            'name' => fake()->company(),
            'description' => fake()->catchPhrase(),
            'price' => fake()->randomNumber(2),
            'picture' => 'default.jpg',
            'remember_token' => Str::random(10),
        ];
    }
}
