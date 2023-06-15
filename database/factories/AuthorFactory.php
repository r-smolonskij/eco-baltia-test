<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class AuthorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            "name" => $this->faker->name(),
            "surname" => $this->faker->name(),
            "birth_date" => $this->faker->dateTimeBetween($startDate = '-70 years', $endDate = '-25 years', $timezone = null),
        ];
    }
}
