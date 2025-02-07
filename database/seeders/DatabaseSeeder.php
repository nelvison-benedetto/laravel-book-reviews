<?php

namespace Database\Seeders;

use App\Models\Book;  //added
use App\Models\Review;   //added

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        Book::factory(count: 33)->create()->each(function($book){
            $numReviews = random_int(5,30);
            Review::factory()->count($numReviews)
                ->good()
                ->for($book)
                ->create();
        });
        Book::factory(23)->create()->each(function($book){
            $numReviews = random_int(5,30);
            Review::factory()->count($numReviews)
                ->bad()
                ->for($book)
                ->create();
        });
    }
}
