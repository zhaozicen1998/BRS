<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard(); //解除模型的批量填充限制
        $this->call(UserSeeder::class);
        $this->call(GenreSeeder::class);
        $this->call(BookSeeder::class);
        $this->call(BorrowSeeder::class);
        Model::reguard();
    }
}
