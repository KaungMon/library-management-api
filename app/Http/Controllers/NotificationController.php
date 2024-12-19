<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Notifications\DatabaseNotification;

class NotificationController extends Controller
{
    public function index () {
        $notifications = DatabaseNotification::all();

        return response()->json([
            'notifications' => $notifications
        ], 200);
    }
}
