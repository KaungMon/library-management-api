<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    // SECTION - create
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
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

    // SECTION - logout
    public function logout(Request $request)
    {
        $user_id = $request->user_id;
        if ($user_id == Auth::user()->id) {
            Auth::guard('web')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return response()->json([
                "message" => "Logout successful"
            ], 200);
        } else {
            return response()->json([
                'message' => 'Forbidden'
            ], 403);
        }
    }
    // !SECTION

    // SECTION - profile
    public function index(Request $request)
    {
        $id = $request->user()->id;
        $user = User::with(['role'])->where('id', $id)->first();

        $data = $this->getData($user);
        return response()->json([
            "user" => $data,
        ], 200);
    }
    // !SECTION

    // SECTION - edit profile
    public function edit(Request $request)
    {
        $data = $request->only([
            "email",
            "username",
            "first_name",
            "surname",
            "gender",
            "address",
            "phone"
        ]);

        User::where('id', Auth::user()->id)->update($data);

        $user = Auth::user();
        $user_data = $this->getData($user);

        return response()->json([
            "message" => "Edit Successful!!!",
            "user" => $user_data,
        ], 200);
    }
    // !SECTION

    // SECTION - delete account
    public function delete_account(Request $request)
    {
        $request->validate([
            'username' => ['required']
        ]);
        $id = Auth::user()->id;
        $username = Auth::user()->username;
        if ($id === 1) {
            return response()->json([
                'message' => 'Master admin cannot be deleted'
            ], 403);
        } else {
            if ($username === $request->username) {
                $user = User::where("id", $id)->first();
                $user->delete();
                Auth::guard('web')->logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
                return response()->json([
                    "message" => "Account deleted successfully."
                ], 200);
            } else {
                return response()->json([
                    "message" => "The username is incorrect."
                ], 422);
            }
        }
    }
    // !SECTION

    // SECTION - change password
    public function change_password(Request $request)
    {
        $dbPassword = Auth::user()->password;
        $hashCheck = Hash::check($request->currentPassword, $dbPassword);
        if ($hashCheck) {
            $data = [
                'password' => Hash::make($request->newPassword),
            ];
            User::where('id', Auth::user()->id)->update($data);
            Auth::guard('web')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return response()->json([
                "message" => "Password Changed!!!"
            ], 200);
        } else {
            return response()->json([
                "message" => "Password Change Unable!!!"
            ]);
        }
    }
    // !SECTION

    // SECTION - update image
    public function update_image(Request $request)
    {
        $request->validate([
            'image' => 'required|image|max:2048',
        ]);
        $id = Auth::user()->id;
        $oldImageName = User::where("id", $id)->first()->image;
        if ($oldImageName != null) {
            Storage::delete('public/image/' . $oldImageName);
        }
        $newImageName = uniqid() . '.' . $request->file('image')->getClientOriginalName();
        logger($newImageName);
        $request->file('image')->storeAs('public/image/', $newImageName);
        $data['image'] = $newImageName;
        User::where("id", $id)->update($data);

        return response()->json([
            "message" => "Update Image Successfully!!!"
        ]);
    }
    // !SECTION

    // SECTION - delete image
    public function delete_image()
    {
        $id = Auth::user()->id;
        $imageName = User::where("id", $id)->first()->image;
        if ($imageName != null) {
            Storage::delete('public/image/' . $imageName);
            $data["image"] = null;
            User::where("id", $id)->update($data);
        }
        return response()->json([
            "message" => "Delete Image Successfully!!!"
        ]);
    }
    // !SECTION

    // SECTION - get data
    private function getData($data)
    {
        return [
            "id" => $data->id,
            "first_name" => $data->first_name,
            "surname" => $data->surname,
            "username" => $data->username,
            "address" => $data->address,
            "phone" => $data->phone,
            "gender" => $data->gender,
            "email" => $data->email,
            "role" => $data->role->role_name,
            "image" => $data->image ? asset('storage/image/' . $data->image) : null,
        ];
    }
    // !SECTION
}
