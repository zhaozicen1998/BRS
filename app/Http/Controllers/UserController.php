<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Borrow;
use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    // 注册
    // Register
    public function register(Request $request)
    {
        $data = $request->input();
        try {
            $id = DB::table('users')->insertGetId($data);
            session(['user' => ['id' => $id, 'username' => $data['name'], 'is_librarian' => 0]]);
            return response()->json(array('code' => 200, 'msg' => "Register successful!"));
        } catch (QueryException $e) {
            return response()->json(array('code' => 601, 'msg' => "Register failed!"));
        }
    }

    // 登出
    // Logout
    public function logout(Request $request)
    {
        $request->session()->forget('user');
        return response()->json(array('code' => 200, 'msg' => "Logout successful!"));
    }

    // 登陆
    // Login
    public function login(Request $request)
    {
        $data = $request->input();
        $user = DB::table('users')->where($data)->first();
        if(!empty($user)) {
            session(['user' => ['id' => $user->id, 'username' => $user->name, 'is_librarian' => $user->is_librarian]]);
            return response()->json(array('code' => 200, 'msg' => "Login successful!"));
        }
        else{
            return response()->json(array('code' => 601, 'msg' => "Incorrect username or password!"));
        }
    }

    // 用户详细信息
    // My account
    public function myAccount()
    {
        if(!empty(session(('user')))) {
            $userid = session('user')['id'];
            $users = User::find($userid);
            return response()->json([
                'user' => $users
            ]);
        }
    }
}
