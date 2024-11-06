<?php

namespace App\Http\Controllers;

use App\Models\Author;
use Illuminate\Http\Request;

class AuthorsController extends Controller
{

    // SECTION - create author
    public function create(Request $request)
    {
        $data = $this->getData($request);
        Author::create($data);
        return response()->json([
            'message' => 'success'
        ], 200);
    }
    // !SECTION

    // SECTION - author lists
    public function lists()
    {
        $authors = Author::withCount('books')->get();
        return response()->json([
            'authors' => $authors
        ], 200);
    }
    // !SECTION

    // SECTION - update author
    public function update(Request $request)
    {
        $data = $this->getData($request);
        $id = $request->authorId;
        Author::where('id', $id)->update($data);
    }
    // !SECTION

    // SECTION - get data
    private function getData($request)
    {
        return [
            'author_name' => $request->authorName
        ];
    }
    // !SECTION
}
