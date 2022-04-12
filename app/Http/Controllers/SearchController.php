<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Genre;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;

class SearchController extends Controller
{
    // 搜索
    public function search(Request $request)
    {
        Paginator::defaultView('vendor.pagination.bootstrap-5');
        $data = $request->input();
        if(sizeof($data) >= 2)
        {
            // 防止关键字置空爆出全部字段
            if($data['searchKeyword'] !== null)
            {
                // 根据书名查询
                if($data['searchWays'] === "1")
                {
                    $results = Book::where('title','LIKE','%'.$data['searchKeyword'].'%')->orderBy("id")->paginate(5)->withQueryString();
                    $data = [
                        'results' => $results
                    ];
                    return view('search.search',$data);
                }
                // 根据作者查询
                else{
                    $results = Book::where('authors','LIKE','%'.$data['searchKeyword'].'%')->orderBy("id")->paginate(5)->withQueryString();
                    $data = [
                        'results' => $results
                    ];
                    return view('search.search',$data);
                }
            }
            else
            {
                // 故意搜索一个不存在的项
                $results = Book::where('id','9999999')->paginate(5)->withQueryString();
                $data = ['results' => $results];
                return view('search.search',$data);
            }
        }
        else
        {
            $results = Book::where('id','9999999')->paginate(5)->withQueryString();
            $data = ['results' => $results];
            return view('search.search',$data);
        }
    }

    // 按类索引
    // 这个模块有冗余代码，后续可以优化
    public function genre(Request $request)
    {
        Paginator::defaultView('vendor.pagination.bootstrap-5');
        $data = $request->input();
        if (sizeof($data) >= 2)
        {
            if(sizeof($data) == 2 && key_exists('page',$data))
            {
                if(key_exists('genreName',$data))
                {
                    $genreids = Genre::where('name',$data['genreName'])->pluck('id');
                    $results = new Book();
                    foreach ($genreids as $genreid)
                    {
                        $results = $results->orWhere('genre_id',$genreid);
                    }
                    $results = $results->orderBy("id")->paginate(5)->withQueryString();
                }
                else
                {
                    $genreids = Genre::where('style',$data['genreStyle'])->pluck('id');
                    $results = new Book();
                    foreach ($genreids as $genreid)
                    {
                        $results = $results->orWhere('genre_id',$genreid);
                    }
                    $results = $results->orderBy("id")->paginate(5)->withQueryString();
                }
            }
            else
            {
                if ($data['genreName'] !== null && $data['genreStyle'] !== null)
                {
                    $genre = Genre::where('name',$data['genreName'])->where('style',$data['genreStyle'])->first();
                    $results = $genre->books()->orderBy("id")->paginate(5)->withQueryString();
                }
                elseif ($data['genreName'] === null && $data['genreStyle'] !== null){
                    $genreids = Genre::where('style',$data['genreStyle'])->pluck('id');
                    $results = new Book();
                    foreach ($genreids as $genreid)
                    {
                        $results = $results->orWhere('genre_id',$genreid);
                    }
                    $results = $results->orderBy("id")->paginate(5)->withQueryString();
                }
                elseif ($data['genreStyle'] === null && $data['genreName'] !== null) {
                    $genreids = Genre::where('name', $data['genreName'])->pluck('id');
                    $results = new Book();
                    foreach ($genreids as $genreid) {
                        $results = $results->orWhere('genre_id', $genreid);
                    }
                    $results = $results->orderBy("id")->paginate(5)->withQueryString();
                }
                else
                {
                    $results = Book::query()->orderBy("id")->paginate(5)->withQueryString();
                }
            }
        }
        elseif (sizeof($data) === 1){
            if(key_exists('page',$data))
            {
                $results = Book::query()->orderBy("id")->paginate(5)->withQueryString();
            }
            else{
                if(key_exists('genreName',$data))
                {
                    $genreids = Genre::where('name',$data['genreName'])->pluck('id');
                    $results = new Book();
                    foreach ($genreids as $genreid)
                    {
                        $results = $results->orWhere('genre_id',$genreid);
                    }
                    $results = $results->orderBy("id")->paginate(5)->withQueryString();
                }
                else
                {
                    $genreids = Genre::where('style',$data['genreStyle'])->pluck('id');
                    $results = new Book();
                    foreach ($genreids as $genreid)
                    {
                        $results = $results->orWhere('genre_id',$genreid);
                    }
                    $results = $results->orderBy("id")->paginate(5)->withQueryString();
                }
            }
        }
        else{
            $results = Book::query()->orderBy("id")->paginate(5)->withQueryString();
        }

        $data = [
            'results' => $results
        ];
        return view('search.search',$data);
    }

    // 书本详情页
    public function searchDetail($id)
    {
        $book = Book::find($id);
        // 模型的关联查询
        $genre = $book->genres()->first();
        $borrowed_book = $book->borrows();
        // orWhere查询放至闭包中防止前面的where查询失效
        $borrowed = $borrowed_book->where(function ($borrowed_book) {
            $borrowed_book->where('status','ACCEPTED')->orWhere('status','PENDING');
        })->count();
        $notborrowed = ($book['in_stock']) - $borrowed;
        return response()->json([
            'data' => $book,
            'genre' => $genre,
            'notborrowed' => $notborrowed
        ]);
    }
}
