<?php

namespace Database\Factories;

use App\Models\Author;
use Illuminate\Database\Eloquent\Factories\Factory;

class BookFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            "title" => $this->faker->words(3, true),
            "description" =>$this->faker->text(),
            "date_of_issue" => $this->faker->dateTimeBetween($startDate = '-5 years', $endDate = '-2 years', $timezone = null),
        ];
    }
}
