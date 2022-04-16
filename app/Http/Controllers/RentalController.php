<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Borrow;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB;

class RentalController extends Controller
{
    // 借书
    // Borrow book
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
            return response()->json(array('code' => 200, 'msg' => "Loan request sent successfully!"));
        }
        else{
            $status = $book->borrows()->where('reader_id',$userid)->pluck('status')->filter(function ($value, $key) {
                return $value != 'RETURNED';
            })->values()->all();
            return response()->json(array('code' => 601, 'msg' => "FAIL! You have an ongoing loan for this book! Status: $status[0]"));
        }
    }

    // 我的借阅
    // My rental
    public function myrental(Request $request)
    {
        Paginator::defaultView('vendor.pagination.bootstrap-5');
        $status = str_replace('myrental','',$request->path());
        $status = strtoupper(str_replace('/','',$status));
        // 这里添加此判断的原因是，如果用户在这个页面退出登陆，则跳转到主页
        // 跳转在js中实现
        if(!empty(session('user')))
        {
            $userid = session('user')['id'];
            if($status === '')
            {
                $rentals = Borrow::where('reader_id',$userid)->where('status','PENDING')->get();
                $results = Borrow::where('reader_id',$userid)->where('status','PENDING')->orderBy("id")->paginate(5)->withQueryString();
            }
            else if($status === 'PENDING'  || $status === 'REJECTED' || $status === 'RETURNED')
            {
                $rentals = Borrow::where('reader_id',$userid)->where('status',$status)->get();
                $results = Borrow::where('reader_id',$userid)->where('status',$status)->orderBy("id")->paginate(5)->withQueryString();
            }
            else
            {
                $now = Carbon::now()->toDateTimeString();
                if($status === 'LATE')
                {
                    $rentals = Borrow::where('reader_id',$userid)->where('status','ACCEPTED')->where('deadline','<',$now)->get();
                    $results = Borrow::where('reader_id',$userid)->where('status','ACCEPTED')->where('deadline','<',$now)->orderBy("id")->paginate(5)->withQueryString();
                }
                else
                {
                    $rentals = Borrow::where('reader_id',$userid)->where('status','ACCEPTED')->where('deadline','>=',$now)->get();
                    $results = Borrow::where('reader_id',$userid)->where('status','ACCEPTED')->where('deadline','>=',$now)->orderBy("id")->paginate(5)->withQueryString();
                }
            }
            $books = new Book();
            foreach ($rentals as $rental)
            {
                $bookname = $rental->books()->pluck('title')->first();
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
    // Rental detail
    public function rentalDetail($id)
    {
        $borrow = Borrow::find($id);
        $users = Borrow::find($id)->borrowedReader()->first();
        $requestedManagers = Borrow::find($id)->requestedManager()->first();
        $returnedManagers = Borrow::find($id)->returnedManager()->first();
        return response()->json([
            'data' => $borrow,
            'user' => $users,
            'requestedManager' => $requestedManagers,
            'returnedManager' => $returnedManagers
        ]);
    }
}
