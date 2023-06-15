<?php

namespace Database\Factories;

use App\Models\Book;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            "book_id" => Book::factory(),
            "order_date" => $this->faker->dateTimeBetween($startDate = '-1 years', $endDate = '- 1 days', $timezone = null)
        ];
    }
}
