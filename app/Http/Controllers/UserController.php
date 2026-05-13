<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function login(Request $request) {
        $user = User::where('email', $request->email)->get();
        logger($request);
        logger($user);
        if(Hash::check($request->password, $user->password)) {
            return response()->json([
                "message" => "success",
                "user" => $user
            ], 200);
        }else {
            return response()->json([
                "message" => "Error"
            ], 200);
        }
    }
}
