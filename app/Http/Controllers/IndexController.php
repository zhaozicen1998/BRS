<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Borrow;
use App\Models\Genre;
use App\Models\User;

class IndexController extends Controller
{
    public function index()
    {
        $usersCount = User::count();
        $booksCount = Book::count();
        $genresCount = Genre::count();
        $acceptCount = Borrow::where("status","ACCEPTED")->count();
        $data = [
            'usersCount' => $usersCount,
            'booksCount' => $booksCount,
            'genresCount' => $genresCount,
            'acceptCount' => $acceptCount
        ];
        return view("index.index", $data);
    }
    public function test()
    {
//        $users = Genre::find(3)->books;
//        return $users;
        return view("test");
    }
}
