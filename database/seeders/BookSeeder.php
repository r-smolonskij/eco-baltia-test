<?php

namespace Database\Seeders;

use App\Models\Book;
use Illuminate\Database\Seeder;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Book::factory()->count(5)->hasOrders(10)->create();
        Book::factory()->count(5)->hasOrders(17)->hasAuthors(2)->create();
        Book::factory()->count(3)->hasOrders(22)->hasAuthors(1)->create();
        Book::factory()->count(1)->hasOrders(30)->hasAuthors(3)->create();
    }
}
