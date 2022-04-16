<?php

namespace App\Http\Controllers;

use App\Helpers\PaginationHelper;
use App\Models\Book;
use App\Models\Borrow;
use App\Models\Genre;
use App\Models\User;
use Carbon\Carbon;
use Doctrine\DBAL\Platforms\Keywords\ReservedKeywordsValidator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Storage;

class ManageController extends Controller
{
    // 添加新书
    // Add new book
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
            return response()->json(array('code' => 200, 'msg' => "Add successful!"));
        }
        else{
            return response()->json(array('code' => 601, 'msg' => "Add failed!"));
        }
    }

    // 添加新书界面
    // Add new book interface
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
    // Upload book cover image
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
    // Edit book
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
            return response()->json(array('code' => 200, 'msg' => "Edit successful!"));
        }
        else
        {
            return response()->json(array('code' => 601, 'msg' => "Edit failed!"));
        }
    }

    // 删除书本
    // Delete book
    public function deleteBook(Request $request)
    {
        $data = $request->input();
        $books = Book::find($data['id']);
        if($books->delete())
        {
            return response()->json(array('code' => 200, 'msg' => "Delete successful!"));
        }
        else{
            return response()->json(array('code' => 601, 'msg' => "Delete failed!"));
        }
    }

    // 流派列表
    // Genre list
    public function genreList(Request $request)
    {
        Paginator::defaultView('vendor.pagination.bootstrap-5');
        $results = Genre::query()->orderBy("id")->paginate(5)->withQueryString();
        $data = [
            'results' => $results
        ];
        return view('genre.genre',$data);
    }

    // 添加新流派
    // Add new genre
    public function addGenre(Request $request)
    {
        $data = $request->input();
        $exist = Genre::where('name',$data['name'])->where('style',$data['style'])->first();
        if($exist != null)
        {
            return response()->json(array('code' => 601, 'msg' => "Failed to add! The genre already exists!"));
        }
        else{
            $genres = new Genre();
            $genres->name = $data['name'];
            $genres->style = $data['style'];
            $genres->save();
            return response()->json(array('code' => 200, 'msg' => "Add successful!"));
        }
    }

    // 编辑流派页面
    // Edit genre interface
    public function editGenrePage(Request $request)
    {
        $data = $request->input();
        $genres = Genre::where('id',$data['id'])->first();
        return response()->json([
            'data' => $genres
        ]);
    }

    // 编辑流派
    // Edit genre
    public function editGenre(Request $request)
    {
        $data = $request->input();
        $exist = Genre::where('name',$data['name'])->where('style',$data['style'])->first();
        if($exist != null)
        {
            return response()->json(array('code' => 601, 'msg' => "Edit failed! The genre already exists!"));
        }
        else{
            $genres = Genre::find($data['id']);
            $genres->name = $data['name'];
            $genres->style = $data['style'];
            if($genres->save())
            {
                return response()->json(array('code' => 200, 'msg' => "Edit successful!"));
            }
            else
            {
                return response()->json(array('code' => 601, 'msg' => "Edit failed!"));
            }
        }
    }

    // 删除流派
    // Delete genre
    public function deleteGenre(Request $request)
    {
        $data = $request->input();
        $genres = Genre::find($data['id']);
        if($genres->delete())
        {
            return response()->json(array('code' => 200, 'msg' => "Delete successful!"));
        }
        else{
            return response()->json(array('code' => 601, 'msg' => "Delete failed!"));
        }
    }

    // 借阅管理列表
    // Rental list
    public function rental(Request $request)
    {
        Paginator::defaultView('vendor.pagination.bootstrap-5');
        $status = str_replace('rental','',$request->path());
        $status = strtoupper(str_replace('/','',$status));
        if($status === '')
        {
            $rentals = Borrow::where('status','PENDING')->get();
            $results = Borrow::where('status','PENDING')->orderBy("id")->paginate(5)->withQueryString();
        }
        else if($status === 'PENDING'  || $status === 'REJECTED' || $status === 'RETURNED')
        {
            $rentals = Borrow::where('status',$status)->get();
            $results = Borrow::where('status',$status)->orderBy("id")->paginate(5)->withQueryString();
        }
        else
        {
            $now = Carbon::now('GMT+2')->toDateTimeString();
            if($status === 'LATE')
            {
                $rentals = Borrow::where('status','ACCEPTED')->where('deadline','<',$now)->get();
                $results = Borrow::where('status','ACCEPTED')->where('deadline','<',$now)->orderBy("id")->paginate(5)->withQueryString();
            }
            else
            {
                $rentals = Borrow::where('status','ACCEPTED')->where('deadline','>=',$now)->get();
                $results = Borrow::where('status','ACCEPTED')->where('deadline','>=',$now)->orderBy("id")->paginate(5)->withQueryString();
            }
        }
        $books = new Collection();
        $users = new Collection();
        foreach ($rentals as $rental)
        {
            $bookname = $rental->books()->pluck('title')->first();
            $books = $books->push(Book::where('title',$bookname));
            $username = $rental->borrowedReader()->pluck('name')->first();
            $users = $users->push(User::where('name',$username));
        }
        $books = PaginationHelper::paginate($books, 5);
        $users = PaginationHelper::paginate($users, 5);
        $books = $books->withQueryString();
        $users = $users->withQueryString();
        $data = [
            'results' => $results,
            'books' => $books,
            'users' => $users
        ];
        return view('librarian.rental',$data);
    }

    // 给借阅接受、拒绝、还书等的模态框（确认框）传值
    // Passing values to the modal boxes
    public function rentalFind(Request $request)
    {
        $data = $request->input();
        $books = Borrow::find($data['id'])->books()->first();
        $users = Borrow::find($data['id'])->borrowedReader()->first();
        return response()->json([
            'book' => $books,
            'user' => $users
        ]);
    }

    // pending -> accepted
    public function toAccept(Request $request)
    {
        $data = $request->input();
        $borrows = Borrow::find($data['id']);
        $borrows->status = "ACCEPTED";
        $borrows->request_processed_at = date('Y-m-d H:i:s', time());
        $borrows->request_managed_by = session('user')['id'];
        $borrows->deadline = $data['deadline'];
        if($borrows->save())
        {
            return response()->json(array('code' => 200, 'msg' => "Borrowing accepted successfully!"));
        }
        else
        {
            return response()->json(array('code' => 601, 'msg' => "Borrowing acceptance failed!"));
        }
    }

    // pending -> rejected
    public function toReject(Request $request)
    {
        $data = $request->input();
        $borrows = Borrow::find($data['id']);
        $borrows->status = "REJECTED";
        $borrows->request_processed_at = date('Y-m-d H:i:s', time());
        $borrows->request_managed_by = session('user')['id'];
        if($borrows->save())
        {
            return response()->json(array('code' => 200, 'msg' => "Borrowing refusal successful!"));
        }
        else
        {
            return response()->json(array('code' => 601, 'msg' => "Borrowing refusal failed!"));
        }
    }

    // 还书
    // Return book
    public function returnBook(Request $request)
    {
        $data = $request->input();
        $borrows = Borrow::find($data['id']);
        $borrows->status = "RETURNED";
        $borrows->returned_at = date('Y-m-d H:i:s', time());
        $borrows->return_managed_by = session('user')['id'];
        if($borrows->save())
        {
            return response()->json(array('code' => 200, 'msg' => "Book return success!"));
        }
        else
        {
            return response()->json(array('code' => 601, 'msg' => "Book return failed!"));
        }
    }

}
