<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $response = Http::get('https://placebeard.it/640x360');
        if ($response->successful()) {
            $image = $response->body();

            $filename = fake()->firstName().'.jpg';
            $owner_picture_path = '/fileupload/owner/profile/'.$filename;
            file_put_contents(base_path().'/public'.$owner_picture_path, $image);

            return [
                'roles' => '', //to be determine in seeder
                'fname' => fake()->firstName(),
                'lname' => fake()->lastName(),
                'email' => fake()->unique()->safeEmail(),
                'picture' => $filename,
                'email_verified_at' => now(),
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                'remember_token' => Str::random(10),
            ];
        }
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
