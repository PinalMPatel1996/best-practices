<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $filePath = Str::random(10) . '.jpg';
        UploadedFile::fake()->image('id_proof.jpg')->storeAs('public/posts', $filePath);
        $visibilities = Post::visibilities();

        return [
            'user_id' => self::factoryForModel(User::class),
            'title' => $this->faker->name(),
            'body' => $this->faker->text(),
            'file_path' => 'posts/' . $filePath,
            'visibility' => $visibilities[array_rand($visibilities)],
            'is_published' => $this->faker->boolean(),

        ];
    }
}
