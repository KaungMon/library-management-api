<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BooksTableController extends Controller
{
    // SECTION - create book
    public function create(Request $request)
    {
        $data = $this->getData($request);
        $this->validationCheck($request);
        if ($request->hasFile('image')) {
            $newImageName = uniqid() . $request->image->getClientOriginalName();
            $data['image'] = $newImageName;
            $request->image->storeAs('public/image/' . $newImageName);
        }
        return response()->json(['message' => 'success'], 200);
    }
    // !SECTION

    // SECTION - get data
    private function getData($request)
    {
        return [
            'title' => $request->title,
            'publisher' => $request->publisher,
            'published_year' => $request->published_year,
            'author_id' => $request->author_id
        ];
    }
    // !SECTION

    // SECTION - validation check
    private function validationCheck($request)
    {
        $validationRules = [
            "title" => "required",
            "publisher" => "required",
            "published_year" => "required",
            "author_id" => "required",
            // "image" => "image"
        ];

        Validator::make($request->all(), $validationRules)->validate();
    }
    // !SECTION
}
