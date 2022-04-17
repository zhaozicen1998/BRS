<?php

namespace Database\Factories;

use App\Models\Book;
use App\Models\Borrow;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class BorrowFactory extends Factory
{
    protected $model = Borrow::class;

    public function definition(): array
    {
        return [
            'status' => 'RETURNED',
            'request_processed_at' => $this->faker->time('Y-m-d H:i:s', 'now'),
//            'deadline' => $this->faker->time('Y-m-d H:i:s'),
            'deadline' => $this->faker->dateTimeBetween('2021-01-01', '2023-02-05'),
            'returned_at' => $this->faker->time('Y-m-d H:i:s', 'now'),
            'created_at' => $this->faker->time('Y-m-d H:i:s', 'now'),
            'updated_at' => Carbon::now(),

            'reader_id' => User::factory(),
            'book_id' => Book::factory(),
            'request_managed_by' => User::factory(),
            'return_managed_by' => User::factory(),
        ];
    }

    public function pending()
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => 'PENDING',
                'deadline' => null,
                'returned_at' => null,
                'request_processed_at' => null,
                'request_managed_by' => null,
                'return_managed_by' => null,
            ];
        });
    }

    public function rejected()
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => 'REJECTED',
                'deadline' => null,
                'returned_at' => null,
                'return_managed_by' => null,
            ];
        });
    }

    public function accepted()
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => 'ACCEPTED',
                'returned_at' => null,
                'return_managed_by' => null,
            ];
        });
    }
}
