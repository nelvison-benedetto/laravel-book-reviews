<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Book>
 */
class BookFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title'=>fake()->sentence(3), //3 parole random
            'author'=>fake()->name,   //nome random i.e. Neil Boinberon
            'created_at'=>fake()->dateTimeBetween('-2 years'),  //date random in last 2 years
            'updated_at'=>fake()->dateTimeBetween('created_at','now')  //date random between created_at-now
        ];
    }
}
