<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    // SECTION - create
    public function create(Request $request)
    {
        logger($request->userInfo['first_name']);
    }
    // !SECTION
}
