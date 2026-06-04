<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    // SECTION - create
    public function login(Request $request) {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if(Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return response()->json([
                "message" => "Login successfully",
                "user_id" => Auth::user()->id,

            ], 202);
        } else {
            return response()->json([
                "message" => "Invalid email or password."
            ], 401);
        }
    }
    // !SECTION

    // SECTION - register
    public function signup(Request $request)
    {

        $data = $this->getData($request);
        $data["user_role_id"] = 1;
        logger($data);
        User::create($data);
        $user = User::where("email", $data["email"])->first();
        logger($user);
        return response()->json([
            "user" => $user,
            "token" => $user->createToken(time())->plainTextToken,
        ]);
    }
    // !SECTION

    // SECTION - logout
    public function logout(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return response()->json([
            'message' => 'Successfully logged out'
        ], 200);
    }
    // !SECTION

    public function info(Request $request) {
        return $request->user();
    }

    // SECTION - get data
    private function getData($request)
    {
        return [
            "first_name" => $request->firstName,
            "surname" => $request->surname,
            "address" => $request->address,
            "phone" => $request->phone,
            "gender" => $request->gender,
            "email" => $request->email,
            "username" => $request->username,
            "password" => Hash::make($request->password),
        ];
    }
    // !SECTION
}
