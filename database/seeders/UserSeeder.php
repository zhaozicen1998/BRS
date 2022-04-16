<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'name' => 'zhao',
            'email' => 'reader@brs.com',
            'password' => 'password',
            'is_librarian' => 0
        ]);
        User::create([
            'name' => 'xi',
            'email' => 'librarian@brs.com',
            'password' => 'password',
            'is_librarian' => 1
        ]);
        User::factory(User::class)->count(50)->create();
    }
}
