<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Borrow;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    // 注册
    public function register(Request $request)
    {
        $data = $request->input();
        try {
            $id = DB::table('users')->insertGetId($data);
            session(['user' => ['id' => $id, 'username' => $data['name'], 'is_librarian' => 0]]);
            return response()->json(array('code' => 200, 'msg' => "注册成功！"));
        } catch (QueryException $e) {
            return response()->json(array('code' => 601, 'msg' => "注册失败！"));
        }
    }

    // 登出
    public function logout(Request $request)
    {
        $request->session()->forget('user');
        return response()->json(array('code' => 200, 'msg' => "退出成功！"));
    }

    // 登陆
    public function login(Request $request)
    {
        $data = $request->input();
        $user = DB::table('users')->where($data)->first();
        if(!empty($user)) {
            session(['user' => ['id' => $user->id, 'username' => $user->name, 'is_librarian' => $user->is_librarian]]);
            return response()->json(array('code' => 200, 'msg' => "登陆成功！"));
        }
        else{
            return response()->json(array('code' => 601, 'msg' => "用户名或密码不正确！"));
        }
    }
}
