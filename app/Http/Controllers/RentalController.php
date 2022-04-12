<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Borrow;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB;

class RentalController extends Controller
{
    // 借书
    public function borrow(Request $request)
    {
        $data = $request->input();
        $book = Book::whereId($data)->first();
        $userid = session('user')['id'];
        if($book->borrows()->where(
                'reader_id',$userid)->first() == null ||
            ($book->borrows()->where('reader_id',$userid)->pluck('status')->doesntContain('PENDING') &&
                $book->borrows()->where('reader_id',$userid)->pluck('status')->doesntContain('REJECTED') &&
                $book->borrows()->where('reader_id',$userid)->pluck('status')->doesntContain('ACCEPTED')))
        {
            $book->borrows()->create([
                'reader_id' => $userid,
                'status' => "PENDING"
            ]);
            return response()->json(array('code' => 200, 'msg' => "借阅请求发送成功！"));
        }
        else{
            $status = $book->borrows()->where('reader_id',$userid)->pluck('status')->filter(function ($value, $key) {
                return $value != 'RETURNED';
            })->values()->all();
            return response()->json(array('code' => 601, 'msg' => "失败！您对本书有正在进行中的借阅！状态：$status[0]"));
        }
    }

    // 我的借阅
    public function myrental()
    {
        Paginator::defaultView('vendor.pagination.bootstrap-5');
        // 这里添加此判断的原因是，如果用户在这个页面退出登陆，则跳转到主页
        // 跳转在js中实现
        if(!empty(session('user')))
        {
            $userid = session('user')['id'];
            $pendings = Borrow::where('reader_id',$userid)->where('status','PENDING')->get();
            $results = Borrow::where('reader_id',$userid)->where('status','PENDING')->orderBy("id")->paginate(5)->withQueryString();
            $books = new Book();
            foreach ($pendings as $pending)
            {
                $bookname = $pending->books()->pluck('title')->first(); //红楼梦
                $books = $books->orWhere('title',$bookname);
            }
            $books = $books->orderBy("id")->paginate(5)->withQueryString();
            $data = [
                'results' => $results,
                'books' => $books
            ];
            return view('reader.rental',$data);
        }
    }

    // 借阅详情
    public function rentalDetail($id)
    {
        $borrow = Borrow::find($id);
        return response()->json([
            'data' => $borrow
        ]);
    }
}
