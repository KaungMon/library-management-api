<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Notifications\DatabaseNotification;

use function Laravel\Prompts\error;

class NotificationController extends Controller
{
    public function index () {
        $notifications = DatabaseNotification::orderBy('created_at','desc')->get()->all();

        return response()->json([
            'notifications' => $notifications
        ], 200);
    }

    public function delete () {
        DatabaseNotification::select('*')->delete();

        try{
            return response()->json([
                'message' => 'success'
            ], 200);
        } catch (\Exception $error) {
            return response()->json([
                'errors' => $error
            ], 422);
        }
    }
}
