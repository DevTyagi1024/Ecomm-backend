<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{



    // Register API
    public function register(Request $req)
    {
        $user = new User;
        $user->name = $req->name;
        $user->email = $req->email;
        $user->password = Hash::make($req->password);
        $user->save();

        return response()->json([
            'status' => true,
            'user' => $user
        ]);
    }





     // Login API
    public function login(Request $req)
    {
        $req->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $user = User::where('email', $req->email)->first();

        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'User not found'
            ], 400);
        }

        if (!Hash::check($req->password, $user->password)) {
            return response()->json([
                'status' => false,
                'message' => 'Invalid Password'
            ], 400);
        }

        return response()->json([
            'status' => true,
            'user' => $user
        ]);
    }

    // Get api for login
    public function userList()
    {
       $users = User::latest()->get();

       return response()->json([
        'status' => true,
        'users' => $users
      ]);
    }
}