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

        $books = Book::with(['author', 'categories'])->paginate(request('rows'));

        $result = $books->getCollection()->map(function ($book) {
            return [
                'id' => $book->id,
                'title' => $book->title,
                'image' => $book->image,
                'publisher' => $book->publisher,
                'published_year' => $book->published_year,
                'author_name' => $book->author['author_name'],
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
        $id = $request->id;
        $data = [
            'title' => $request->title,
            'publisher' => $request->publisher,
            'published_year' => $request->published_year
        ];

        Book::where('id', $id)->update($data);
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
            "image" => "nullable"
        ];

        Validator::make($request->all(), $validationRules)->validate();
    }
    // !SECTION
}
