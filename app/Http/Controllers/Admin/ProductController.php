<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\Product;
use App\Models\Admin\Category;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function __invoke($categoryId)
    {
        $products = Product::where('fk_category_id', $categoryId)->get();
        $categoryName = Category::where('category_id', $categoryId)->first('category_name')['category_name'];
        $categoryList = Category::select('category_id', 'category_name')->get();
        $condition = [
            'c.category_id' => $categoryId
        ];
        $products = $this->getProducts($condition);
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
            'categoryId' => 'required|string',
            'productCode' => 'required|string|max:50',
            'productName' => 'required|string|max:255',
            'description' => 'string|max:500',
            'gender' => 'string|max:2',
            'keywords' => 'string|max:500',
            'priority' => 'int',
            'status' => 'int'
        ]);

        // Create new category instance
        $product = new Product();
        $product->fk_category_id = $request->input('categoryId');
        $product->product_code = $request->input('productCode');
        $product->product_name = $request->input('productName');
        $product->p_description = $request->input('description');
        $product->gender = $request->input('gender');
        $product->p_keywords = $request->input('keywords');
        $product->priority = $request->input('priority');
        $product->status = $request->input('status');
        $product->save();

        return response()->json(['status' => 'success']);
    }

    public function update(Request $request)
    {
        // Validate request data
        $request->validate([
            'productId' => 'required|int',
            'categoryId' => 'required|string',
            'productCode' => 'required|string|max:50',
            'productName' => 'required|string|max:255',
            'p_description' => 'string|max:500',
            'gender' => 'string|max:2',
            'p_keywords' => 'string|max:500',
            'priority' => 'int',
            'status' => 'int'
        ]);

        // Find the existing product by ID
        $productId = $request->input('productId');
        $product = Product::find($productId);

        if (!$product) {
            return response()->json(['status' => 'error', 'message' => 'Product not found']);
        }

        // Update product attributes
        $product->fk_category_id = $request->input('categoryId');
        $product->product_code = $request->input('productCode');
        $product->product_name = $request->input('productName');
        $product->p_description = $request->input('description');
        $product->gender = $request->input('gender');
        $product->p_keywords = $request->input('keywords');
        $product->priority = $request->input('priority');
        $product->status = $request->input('status');
        $product->save();

        return response()->json(['status' => 'success', 'message' => 'Product updated successfully']);
    }
    public function destroy(Request $request)
    {
        // Validate request data
        $request->validate([
            'product_id' => 'required|integer',
        ]);

        // Delete category
        $product = Product::findOrFail($request->input('product_id'));
        $product->delete();

        return response()->json(['status' => 'success', 'message' => 'Product Deleted Successfull!']);
    }
    public function getProductListAjax(){
        $categoryId = $_POST['categoryId'];
        $condition = [
            'c.category_id' => $categoryId
        ];
        $products = $this->getProducts($condition);
        return response()->json($products);

    }
    public static function getProducts($condition = [])
    {
        $query = Product::select('products.*','c.*', 
        DB::raw('(SELECT img.url
                FROM item_images img
                JOIN items ON img.fk_item_id = items.item_id
                WHERE items.fk_product_id = products.product_id 
                ORDER BY items.priority ASC
                LIMIT 1) AS image_url'));
        $query->join('categories AS c', 'c.category_id' ,  'products.fk_category_id');
        $query->orderBy('products.priority');

        // Apply conditions
        foreach ($condition as $field => $value) {
            // If value is an array, assume it's an operator-value pair
            if (is_array($value)) {
                [$operator, $operand] = $value;
                $query->where($field, $operator, $operand);
            } else {
                // Default to equality operator if no operator is provided
                $query->where($field, '=', $value);
            }
        }
        // prd($query->toSql());
        $products = $query->get();
        return $products;
    }
    public static function GetProductHtml(Request $req){
        $productId = $req->input('productId');
        $Response = getColumnValueByPrimaryKey('products', 'html', ['product_id', $productId]);
        return response()->json($Response);
    }
}
