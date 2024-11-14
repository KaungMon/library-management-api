<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    // SECTION - create category
    public function create(Request $request)
    {

        $data = $this->getData($request);
        Category::create($data);
        return response()->json([
            'message' => 'success'
        ], 200);
    }
    // !SECTION

    // SECTION - category lists
    public function lists()
    {
        $categories = Category::withCount('books')->when(request('key'), function ($query) {
            $query->where('category_name', 'like', '%' . request('key') . '%');
        })->get();
        return response()->json([
            'categories' => $categories
        ], 200);
    }
    // !SECTION

    // SECTION - category update
    public function update(Request $request)
    {
        $data = $this->getData($request);
        $id = $request->categoryId;
        Category::where('id', $id)->update($data);
        return response()->json([
            'message' => 'success'
        ], 200);
    }
    // !SECTION

    // SECTION - category delete
    public function delete($id)
    {
        logger($id);
        Category::where('id', $id)->delete();
        return response()->json([
            'message' => 'success'
        ], 200);
    }
    // !SECTION

    // SECTION - get data
    private function getData($request)
    {
        return [
            'category_name' => $request->categoryName,
        ];
    }
    // !SECTION
}
