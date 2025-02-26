<?php

namespace Database\Seeders;

use App\Models\Book;  //added
use App\Models\Review;   //added

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // User::factory(10)->create();

        Book::factory(count: 33)->create()->each(function($book){  //x ciascuno dei 33books creare reviews...
            $numReviews = random_int(5,30);
            Review::factory()->count($numReviews)
                ->good()   //use funct good() of ReviewFactory.php
                ->for($book)  //equivalente a dire 'book_id' => $book->id, link review-book with book_id field
                ->create();  //lrv creates the reviews and adds them to the db
        });
        Book::factory(23)->create()->each(function($book){
            $numReviews = random_int(5,30);
            Review::factory()->count($numReviews)
                ->bad()  //use funct bad() of ReviewFactory.php
                ->for($book)  //equivalente a dire 'book_id' => $book->id, link review-book with book_id field
                ->create();
        });
    }
}
