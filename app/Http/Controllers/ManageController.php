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

    // 删除书本
    public function deleteBook(Request $request)
    {
        $data = $request->input();
        $books = Book::find($data['id']);
        if($books->delete())
        {
            return response()->json(array('code' => 200, 'msg' => "删除成功！"));
        }
        else{
            return response()->json(array('code' => 601, 'msg' => "删除失败！"));
        }
    }

    // 流派列表
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
    public function addGenre(Request $request)
    {
        $data = $request->input();
        $exist = Genre::where('name',$data['name'])->where('style',$data['style'])->first();
        if($exist != null)
        {
            return response()->json(array('code' => 601, 'msg' => "添加失败！流派已存在！"));
        }
        else{
            $genres = new Genre();
            $genres->name = $data['name'];
            $genres->style = $data['style'];
            $genres->save();
            return response()->json(array('code' => 200, 'msg' => "添加成功！"));
        }
    }

    // 编辑流派页面
    public function editGenrePage(Request $request)
    {
        $data = $request->input();
        $genres = Genre::where('id',$data['id'])->first();
        return response()->json([
            'data' => $genres
        ]);
    }

    // 编辑流派
    public function editGenre(Request $request)
    {
        $data = $request->input();
        $exist = Genre::where('name',$data['name'])->where('style',$data['style'])->first();
        if($exist != null)
        {
            return response()->json(array('code' => 601, 'msg' => "编辑失败！流派已存在！"));
        }
        else{
            $genres = Genre::find($data['id']);
            $genres->name = $data['name'];
            $genres->style = $data['style'];
            if($genres->save())
            {
                return response()->json(array('code' => 200, 'msg' => "修改成功！"));
            }
            else
            {
                return response()->json(array('code' => 601, 'msg' => "修改失败！"));
            }
        }
    }

    // 删除流派
    public function deleteGenre(Request $request)
    {
        $data = $request->input();
        $genres = Genre::find($data['id']);
        if($genres->delete())
        {
            return response()->json(array('code' => 200, 'msg' => "删除成功！"));
        }
        else{
            return response()->json(array('code' => 601, 'msg' => "删除失败！"));
        }
    }

    // 借阅管理列表
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
            return response()->json(array('code' => 200, 'msg' => "借阅接受成功！"));
        }
        else
        {
            return response()->json(array('code' => 601, 'msg' => "借阅接受失败！"));
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
            return response()->json(array('code' => 200, 'msg' => "借阅拒绝成功！"));
        }
        else
        {
            return response()->json(array('code' => 601, 'msg' => "借阅拒绝失败！"));
        }
    }

}
