<?php

namespace Database\Factories;

use App\Models\Image;
use Illuminate\Database\Eloquent\Factories\Factory;

class ImageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    protected $model = Image::class;

    public function definition()
    {
        return [
            'url' => $this->faker->imageUrl(640, 480, 'animals', true),
            'news_id' => $this->faker->numberBetween(1, 100),
        ];
    }
}
