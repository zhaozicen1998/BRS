<?php

namespace Database\Seeders;

use App\Models\Borrow;
use Illuminate\Database\Seeder;

class BorrowSeeder extends Seeder
{
    public function run()
    {
        Borrow::factory(Borrow::class)->count(5)->create();
        Borrow::factory(Borrow::class)->count(5)->pending()->create();
        Borrow::factory(Borrow::class)->count(5)->accepted()->create();
        Borrow::factory(Borrow::class)->count(5)->rejected()->create();
    }
}
