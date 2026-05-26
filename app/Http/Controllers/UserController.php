<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // SECTION - create
    public function login(Request $request)
    {
        $user = User::where('email', $request->email)->first();
        if(isset($user)) {
            if(Hash::check($request->password, $user->password)) {
                return response()->json([
                    'user' => $user,
                    'token' => $user->createToken(time())->plainTextToken
                ], 200);
            }else {
                return response()->json([
                    'user' => null,
                    'token' => null
                ], 200);
            }
        }else {
            return response()->json([
                'user' => null,
                'token' => null
            ], 200);
        }
    }
    // !SECTION

    // SECTION - register
    public function signup(Request $request) {
        $data = $this->getData($request);
        $data["user_role_id"] = 1;
        logger($data);
        User::create($data);
        $user = User::where("email", $data["email"])->first();
        logger($user);
        return response() ->json([
            "user" => $user,
            "token" => $user->createToken(time())->plainTextToken,
        ]);
    }
    // !SECTION

    // SECTION - get data
    private function getData($request) {
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
}
