<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BookCategoryController extends Controller
{
    // SECTION - create book categories
    public function create(Request $request)
    {
        foreach ($request->categories as $category) {
            logger($category['value']);
        }
    }
    // !SECTION
}
