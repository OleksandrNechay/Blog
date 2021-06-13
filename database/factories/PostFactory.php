<?php

namespace Database\Factories;

use App\Models\Post;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class PostFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Post::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $title = $this->faker->sentence(rand(3, 8), true);
        $txt = $this->faker->realText(rand(1000, 4000));
        $isPublished = rand(1, 5) > 1;
        $created_at = $this->faker->dateTimeBetween('-3 months', '-2 months');

        return [
            'user_id' => rand(1, 10),
            'category_id' => rand(1, 11),

            'title'  => $title,
            'slug'   => Str::slug($title),

            'content_raw' => $txt,
            'content_html' => $txt,
            'excerpt' => $this->faker->text(rand(40, 100)),

            'is_published' => $isPublished,
            'published_at' => $isPublished ? $this->faker->dateTimeBetween('-2 months', '-1 days') : null,

            'created_at'   => $created_at,
            'updated_at'   => $created_at,
        ];
    }
}
