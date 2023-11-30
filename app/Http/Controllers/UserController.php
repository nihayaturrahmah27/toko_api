<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function register(Request $request)
    {
        $password = Hash::make($request->input('password'));

        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => $password,
        ]);

        $token = $user->createToken('user_token')->plainTextToken;

        return response()->json([
            'code' => 200,
            'status' => true,
            'data' => 'Registrasi Berhasil'
        ]);
    }

    public function login(Request $request)
    {
        $user = User::where('email', $request->input('email'))->first();

        if ($user && Hash::check($request->input('password'), $user->password)) {
            $token = $user->createToken('user_token')->plainTextToken;

            return response()->json([
                'code' => 200,
                'status' => true,
                'data' => [
                    'token' => $token,
                    'user' => $user,
                ],
            ]);
        } else {
            return response()->json([
                'message' => 'User not found',
                'data' => false,
            ]);
        }
    }

    public function logout(Request $request)
    {
        $user = User::where('email', $request->input('email'))->first();

        $user->tokens()->delete();

        return response()->json([
            'message' => 'User has been logged out successfully'
        ]);
    }
}
