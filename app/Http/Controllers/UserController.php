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
    public function login(Request $request)
    {

        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials, $request->remember_me)) {
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
        logger('--- Debugging Incoming Logout Request ---');
        logger('Full URL: ' . $request->fullUrl());
        logger('Request Method: ' . $request->method());

        // 1. Log all incoming headers (This checks for X-XSRF-TOKEN)
        logger('Headers:', $request->headers->all());

        // 2. Log all incoming cookies (This checks for laravel_session)
        logger('Cookies:', $request->cookies->all());

        return response()->json(['message' => 'Log captured']);
    }
    // !SECTION

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
