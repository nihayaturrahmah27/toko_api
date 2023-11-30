<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $username = $request->input('username');
        $password = md5($request->input('password')); // Consider using bcrypt() instead

        $user = User::where('username', $username)->where('password', $password)->first();

        if ($user) {
            $token = time() . '_' . $user->password; // This might need adjustment
            return response()->json([
                'username' => $user->username,
                'token' => $token,
                'status_login' => 'berhasil',
            ]);
        } else {
            return response()->json(['status_login' => 'gagal']);
        }
    }
}
