<?php

namespace Database\Seeders;

use App\Models\Borrow;
use Illuminate\Database\Seeder;

class BorrowSeeder extends Seeder
{
    public function run()
    {
        Borrow::factory(Borrow::class)->count(50)->create();
    }
}
