<?php

namespace App\Http\Controllers;

use App\Models\Book;
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
        $authors = Author::withCount('books')->when(request('key'), function ($querry) {
            $querry->where('author_name', 'like', '%' . request('key') . '%');
        })->get();
        return response()->json([
            'authors' => $authors
        ], 200);
    }
    // !SECTION

    // SECTION - delete author
    public function delete($id)
    {
        logger($id);
        Author::where('id', $id)->delete();
        // Book::where('author_id', $id)->delete();
        return response()->json([
            "message" => "success"
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
