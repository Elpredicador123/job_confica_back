<?php

namespace Database\Factories;

use App\Models\Reservation;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReservationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    protected $model = Reservation::class;

    public function definition()
    {
        return [
            'title' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
            'date' => $this->faker->dateTime,
            'start_time' => $this->faker->time,
            'end_time' => $this->faker->time,
            'number_of_people' => $this->faker->numberBetween(5, 20),
            'is_active' => $this->faker->boolean,
        ];
    }
}
