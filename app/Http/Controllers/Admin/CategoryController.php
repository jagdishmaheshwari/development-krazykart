<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\Category;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    public function __invoke()
    {
        $categories = Category::select(
            'categories.*',
            DB::raw('(SELECT img.url
                FROM item_images img
                JOIN items ON img.fk_item_id = items.item_id
                JOIN products p ON p.product_id = items.fk_product_id
                WHERE p.fk_category_id = categories.category_id 
                ORDER BY items.priority ASC
                LIMIT 1) AS image_url')
        )->get();

        return view('admin.categories', ['categories' => $categories]);
    }
    public function getCategoryListAjax()
    {
        $categories = Category::select(
            'categories.*',
            DB::raw('(SELECT img.url
                FROM item_images img
                JOIN items ON img.fk_item_id = items.item_id
                JOIN products p ON p.product_id = items.fk_product_id
                WHERE p.fk_category_id = categories.category_id 
                ORDER BY items.priority ASC
                LIMIT 1) AS image_url')
        )->get();
        return response()->json($categories);
    }
    public function show($categoryId)
    {
        $products = Product::where('fk_category_id', $categoryId)->get();
        $categoryName = Category::where('category_id', $categoryId)->first('category_name')['category_name'];
        $categoryList = Category::select('category_id', 'category_name')->get();

        return view('admin.products', [
            'products' => $products,
            'categoryId' => $categoryId,
            'categoryName' => $categoryName,
            'categoryList' => $categoryList
        ]);
    }
    public function store(Request $request)
    {
        // Validate request data
        $request->validate([
            'category_name' => 'required|string',
            'c_description' => 'string',
            'c_keywords' => 'string',
        ]);

        // Create new category instance
        $category = new Category();
        $category->category_name = $request->input('category_name');
        $category->c_description = $request->input('c_description');
        $category->c_keywords = $request->input('c_keywords');
        $category->save();

        return response()->json(['status' => 'success']);
    }

    public function update(Request $request)
    {
        // Validate request data
        $request->validate([
            'category_id' => 'required|integer',
            'category_name' => 'required|string',
            'c_description' => 'string',
            'c_keywords' => 'string',
        ]);

        $category_id = $request->input('category_id');

        // Find the category by its custom primary key (category_id)
        $category = Category::findOrFail($category_id);
        $category->category_name = $request->input('category_name');
        $category->c_description = $request->input('c_description');
        $category->c_keywords = $request->input('c_keywords');
        $category->save();

        return response()->json(['status' => 'success']);
    }

    public function destroy(Request $request)
    {
        // Validate request data
        $request->validate([
            'category_id' => 'required|integer',
        ]);

        // Delete category
        $category = Category::findOrFail($request->input('category_id'));
        $category->delete();

        return response()->json(['status' => 'success']);
    }
}
