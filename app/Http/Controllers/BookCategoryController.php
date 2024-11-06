<?php

namespace App\Http\Controllers;

use App\Models\BookCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BookCategoryController extends Controller
{
    // SECTION - create
    public function create(Request $request)
    {
        if ($request->book_id) {
            $this->validationCheck($request);
            foreach ($request->categories as $category) {
                $data = [
                    'category_id' => $category['value'],
                    'book_id' => $request->book_id,
                ];
                BookCategory::create($data);
            }
            return response()->json([
                'message' => 'success'
            ], 200);
        } else {
            return response()->json([
                'error' => 'book id is required'
            ], 422);
        }
    }
    // !SECTION

    // SECTION - lists
    public function lists()
    {
        $lists = BookCategory::get();

        return response()->json([
            'lists' => $lists,
        ], 200);
    }
    // !SECTION

    // SECTION - validation check
    private function validationCheck($request)
    {
        $validationRules = [
            'book_id' => 'required',
            'categories' => 'required|array|min:1',
        ];
        Validator::make($request->all(), $validationRules)->validate();
    }
    // !SECTION
}
