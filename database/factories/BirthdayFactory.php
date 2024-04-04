<?php

namespace Database\Factories;

use App\Models\Birthday;
use Illuminate\Database\Eloquent\Factories\Factory;

class BirthdayFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    protected $model = Birthday::class;

    public function definition()
    {
        //obtener la fecha actual + un numero random de dias
        $start = now()->addDays(rand(1, 7));
        //obtener la fecha actual + un numero random de dias
        $end = now()->addDays(rand(1, 7));
        return [
            'title' => $this->faker->text(10),
            'start' => $start,
            'end' => $end,
            'is_active' => $this->faker->boolean,
        ];
    }
}
