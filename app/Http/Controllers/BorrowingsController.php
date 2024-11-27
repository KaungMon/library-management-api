<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Book;
use App\Models\User;
use App\Models\Borrowing;
use Illuminate\Http\Request;

class BorrowingsController extends Controller
{
    // SECTION - book lists
    public function book_lists () {
        $books = Book::get();
        $result = $books->map(function ($book) {
            return [
                'name' => $book->title,
                'id' => $book->id
            ];
        });

        return response()->json([
            'books' => $result
        ],200);
    }
    // !SECTION

    // SECTION - create
    public function create(Request $request) {
        logger($request);
        $data = $this->getData($request);
        $borrow_date = Carbon::parse($request->borrow_date)->setTimezone('Asia/Yangon')->format('Y-m-d');
        $due_date = Carbon::parse($request->due_date)->setTimezone('Asia/Yangon')->format('Y-m-d');
        $data['borrow_date'] = $borrow_date;
        $data['return_date'] = $due_date;
        $data['status_id'] = 1;
        Borrowing::create($data);
        return response()->json(['message' => 'success'],200);
    }
    // !SECTION

    // SECTION - lists
    public function lists () {
        $lists = Borrowing::with(['status', 'book', 'librarian', 'member'])->paginate(request('rows'));

        $result = $lists->getCollection()->map(function ($list) {
            return [
                'id' => $list->id,
                'book_title' => $list->book->title,
                'book_image' => $list->book->image,
                'librarian_name' => $list->librarian->username,
                'member_name' => $list->member->username,
                'status' => [
                    'name' => $list->status->status_name,
                    'id' => $list->status->id
                ],
                'borrow_date' => Carbon::parse($list->borrow_date)->setTimezone('Asia/Yangon')->format('M d Y'),
                'due_date' => Carbon::parse($list->return_date)->setTimezone('Asia/Yangon')->format('M d Y')

            ];
        });

        $lists->setCollection($result);

        return response()->json([
            'lists' => $lists
        ]);
    }
    // !SECTION

    // SECTION - librarian lists
    public function librarians () {
        $librarians = User::where('user_role_id', 1)->get();
        $result = $librarians->map(function ($librarian) {
            return [
                'name' => $librarian->username,
                'id' => $librarian->id,
            ];
        });
        return response()->json([
            'librarians' => $result
        ],200);
    }
    // !SECTION

    // SECTION - member lists
    public function members() {
        $members = User::where('user_role_id', 2)->get();
        $result = $members->map(function ($member) {
            return [
                'name' => $member->username,
                'id' => $member->id
            ];
        });

        return response()->json([
            'members' => $result
        ], 200);
    }
    // !SECTION

    // SECTION - update
    public function update(Request $request) {
        $id = $request->id;
        $data = [
            'status_id' => $request->status_id
        ];
        Borrowing::where('id', $id)->update($data);
        return response()->json([
            'message' => 'success'
        ], 200);
    }
    // !SECTION

    // SECTION - get data
    private function getData($request) {
        return [
            'book_id' => $request->book_id,
            'librarian_id' => $request->librarian_id,
            'member_id' => $request->member_id,
        ];
    }
    // !SECTION
}
