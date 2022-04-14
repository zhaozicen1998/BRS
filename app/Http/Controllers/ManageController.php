<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Genre;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ManageController extends Controller
{
    // 添加新书
    public function addBook(Request $request)
    {
        $data = $request->input();
        $books = new Book();
        $books->title = $data['title'];
        $books->authors = $data['author'];
        $books->released_at = $data['released_at'];
        $books->pages = $data['pages'];
        $books->isbn = $data['isbn'];
        $books->in_stock = $data['in_stock'];
        $books->description = $data['description'];
        $books->language_code = $data['language_code'];
        $books->genre_id = $data['genre_id'];
        $books->cover_image = $data['cover_image'];
        if($books->save())
        {
            return response()->json(array('code' => 200, 'msg' => "添加成功！"));
        }
        else{
            return response()->json(array('code' => 601, 'msg' => "添加失败！"));
        }
    }

    // 添加新书界面
    public function addBookPage()
    {
//        $genreNames = Genre::get()->pluck('name')->unique();
//        $genreStyles = Genre::get()->pluck('style')->unique();
//        return response()->json([
//            'genreNames' => $genreNames,
//            'genreStyles' => $genreStyles
//        ]);
        $genres = Genre::all();
        return response()->json(['genres' => $genres]);
    }

    // 上传书籍封面
    public function photo(Request $request)
    {
        $prefix = "book".mt_rand(1,1000);
        $image = $request->photo;
        $Origname = $image->getClientOriginalName();
        $name = $prefix.$Origname;
        $src = "/".$name;
        $realPath = $request->photo->getRealPath();
        Storage::disk('Uploads')->put($src,file_get_contents($realPath));

        $imagePath = "/image/book".$src;
        return response()->json(['imagePath' => $imagePath]);
    }

    // 编辑书本
    public function editBook(Request $request)
    {
        $data = $request->input();
        $books = Book::find($data['id']);
        $books->title = $data['title'];
        $books->authors = $data['author'];
        $books->released_at = $data['released_at'];
        $books->pages = $data['pages'];
        $books->isbn = $data['isbn'];
        $books->in_stock = $data['in_stock'];
        $books->description = $data['description'];
        $books->language_code = $data['language_code'];
        $books->genre_id = $data['genre_id'];
        if($data['cover_image'] !== null)
        {
            $books->cover_image = $data['cover_image'];
        }

        if($books->save())
        {
            return response()->json(array('code' => 200, 'msg' => "修改成功！"));
        }
        else
        {
            return response()->json(array('code' => 601, 'msg' => "修改失败！"));
        }
    }
}
