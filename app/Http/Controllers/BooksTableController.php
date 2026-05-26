<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Storage;
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
        $book = Book::create($data);
        $bookId = $book->id;

        return response()->json([
            'id' => $bookId
        ], 200);
    }
    // !SECTION

    // SECTION - lists
    public function lists()
    {

        $books = Book::with(['author', 'categories'])->when(request('key'), function ($query) {
            $query->orWhere('title', 'like', '%' . request('key') . '%')
                ->orWhere('publisher', 'like', '%' . request('key') . '%')
                ->orWhere('published_year', 'like', '%' . request('key') . '%');
        })->paginate(request('rows'));

        $result = $books->getCollection()->map(function ($book) {
            return [
                'id' => $book->id,
                'title' => $book->title,
                'image' => $book->image,
                'publisher' => $book->publisher,
                'published_year' => $book->published_year,
                'author' => $book->author,
                'categories' => $book->categories->pluck('category_name')
            ];
        });

        $books->setCollection($result);

        return response()->json([
            'books' => $books
        ], 200);
    }
    // !SECTION

    // SECTION - update
    public function update(Request $request)
    {
        $data = $this->getData($request);
        $this->validationCheck($request);
        $id = $request->id;
        if ($request->hasFile('image')) {
            $oldImageName = Book::where('id', $id)->first()->image;
            if ($oldImageName != null) {
                Storage::delete('public/image/' . $oldImageName);
            }
            $newImageName = uniqid() . $request->file('image')->getClientOriginalName();
            $request->file('image')->storeAs('public/image/' . $newImageName);
            $data['image'] = $newImageName;
        }
        logger($data);
        Book::where('id', $id)->update($data);
        return response()->json([
            'message' => 'success'
        ], 200);
    }
    // !SECTION

    // SECTION - book detail
    public function detail($id)
    {
        $book = Book::with(['categories', 'author'])->where('id', $id)->first();
        return response()->json(['book' => $book], 200);
    }
    // !SECTION

    // SECTION - book delete
    public function delete($id)
    {
        Book::where('id', $id)->delete();
        return response()->json([
            'message' => 'success'
        ], 200);
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
            "title" => ["required"],
            "publisher" => "required",
            "published_year" => "required|integer",
            "author_id" => "required",
            "image" => "nullable",
            "has_genres" => "accepted"
        ];

        $validationMessages = [
            "published_year.integer" => "The published year field is required.",
            "has_genres.accepted" => "The genres field is required."
        ];

        Validator::make($request->all(), $validationRules, $validationMessages)->validate();
    }
    // !SECTION
}
