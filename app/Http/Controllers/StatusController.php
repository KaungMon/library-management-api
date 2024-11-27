<?php

namespace App\Http\Controllers;

use App\Models\Status;
use Illuminate\Http\Request;

class StatusController extends Controller
{
    // SECTION - lists
    public function lists () {
        $statuses = Status::get();
        $result = $statuses->map(function ($status) {
            return [
                'name' => $status->status_name,
                'id' => $status->id
            ];
        });
        return response()->json([
            'statuses' => $result
        ],200);

    }
    // !SECTION
}
