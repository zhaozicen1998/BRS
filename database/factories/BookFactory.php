<?php

namespace Database\Factories;

use App\Models\Book;
use App\Models\Genre;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class BookFactory extends Factory
{
    protected $model = Book::class;

    public function definition(): array
    {
        return [
            'title' => $this->faker->word(),
            'authors' => $this->faker->name(),
            'description' => $this->faker->text(20),
            'released_at' => $this->faker->date(),
//            'cover_image' => $this->faker->word(),
            'pages' => $this->faker->numberBetween(1,1000),
            'language_code' => $this->faker->languageCode(),
            'isbn' => $this->faker->unique()->isbn13(),
            'in_stock' => $this->faker->numberBetween(0,100),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

            'genre_id' => Genre::factory(),
        ];
    }
}
