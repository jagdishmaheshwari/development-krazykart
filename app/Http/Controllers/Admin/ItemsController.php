<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models;
use App\Models\Admin\Category;
use App\Models\Admin\Items;
use App\Models\Admin\ItemImage;
use App\Models\Admin\Color;
use App\Models\Admin\Size;
// use Illuminate\Support\Facades\DB;


class ItemsController extends Controller
{
    public function __invoke( $categoryId, $productId)
    {
        $condition = [
            'items.fk_category_id' => $categoryId,
            'items.fk_product_id' => $productId
        ];

        // $products = $this->getItems($condition, '', '', true);

        $sizes = Size::all();
        $colors = Color::all();
        $products = Product::all();
        $categories = Category::all();
        // $items = Items::where('fk_product_id', $productId)->orderBy('priority')->get();
        $items = $this->getItems($condition, '', [], true);
        return view('admin.items', compact('items', 'categoryId','productId','categories','colors','sizes','products'));
    }
    public function view( $categoryId, $productId, $itemId){
        $condition = [
            'items.fk_category_id' => $categoryId,
            'items.fk_product_id' => $productId,
            'items.item_id' => $itemId
        ];
        $items = $this->getItems($condition, '', [], true);
        return view('admin.item', compact('items','itemId'));

    }
    public function store(Request $request)
    {
        // Validate request data
        $request->validate([
            'categoryId' => 'required|int',
            'productId' => 'required|int',
            'colorId' => 'required|int',
            'sizeId' => 'required|int',
            'sellingPrice' => 'numeric|required',
            'offerPrice' => 'required|numeric',
            'priority' => 'nullable|int'
        ]);

        // Create new category instance
        $item = new Items();
        $item->fk_category_id = $request->input('categoryId');
        $item->fk_product_id = $request->input('productId');
        $item->fk_color_id = $request->input('colorId');
        $item->fk_size_id = $request->input('sizeId');
        $item->mrp = $request->input('sellingPrice');
        $item->price = $request->input('offerPrice');
        $item->priority = $request->input('priority');
        $item->save();
        return response()->json(['status' => 'success','message' => 'Item Addedd Sucessfull!']);
    }
    public function update(Request $request)
    {
        // Validate request data
        $request->validate([
            'itemId' => 'required|int',
            'colorId' => 'required|int',
            'sizeId' => 'required|int',
            'sellingPrice' => 'numeric|required',
            'offerPrice' => 'required|numeric',
            'priority' => 'nullable|int'
        ]);

        // Find the existing product by ID
        $itemId = $request->input('itemId');
        $item = Items::find($itemId);

        if (!$item) {
            return response()->json(['status' => 'error', 'message' => 'Item not found']);
        }

        // Update product attributes
        $item->fk_color_id = $request->input('colorId');
        $item->fk_size_id = $request->input('sizeId');
        $item->mrp = $request->input('sellingPrice');
        $item->price = $request->input('offerPrice');
        $item->priority = $request->input('priority');
        $item->save();
        return response()->json(['status' => 'success', 'message' => 'Item updated successfully']);
    }
    public function destroy(Request $request)
    {
        $request->validate([
            'itemId' => 'required|integer',
        ]);

        // Delete category
        $item = Items::findOrFail($request->input('itemId'));
        $item->delete();

        return response()->json(['status' => 'success', 'message' => 'Item Deleted Successfull!']);
    }
    public static function getItems($condition = [], $groupBy = '', $orderBy = [], $admin = false)
    {
        $query = Items::query()
        ->select(
            'items.*',
            'categories.c_description',
            'categories.category_name',
            'products.product_name',
            'products.product_code',
            'products.p_description',
            'products.gender',
            'products.p_keywords',
            'products.status AS p_status',
            'products.priority AS p_priority',
            'colors.color_code',
            'colors.color_name',
            'sizes.size_name',
            'sizes.size_code'
        )
        ->leftJoin('categories', 'items.fk_category_id', '=', 'categories.category_id')
        ->leftJoin('products', 'items.fk_product_id', '=', 'products.product_id')
        ->leftJoin('colors', 'items.fk_color_id', '=', 'colors.color_id')
        ->leftJoin('sizes', 'items.fk_size_id', '=', 'sizes.size_id');
        // prd($query->get());
        


        // Adjust the query based on status
        if (!$admin) {
            $query->where('items.status', 1);
        }

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

        // Append group by
        if (!empty($groupBy)) {
            $query->groupBy($groupBy);
        }
        $orderBy = $orderBy != null ? $orderBy : ['items.priority asc'];
        foreach ($orderBy as $order) {
            [$column, $direction] = explode(' ', trim($order));
            $query->orderBy($column, $direction);
        }
        $items = $query->get();
        
        // Process the items to include image URLs as arrays
        $ItemImage = new ItemImage();
        foreach ($items as $item) {
            $itemImages = $ItemImage->where('fk_item_id', $item->item_id)->pluck('url');
            $item->item_images = $itemImages->map(function ($filename) {
                return asset('storage') . '/' . $filename;
            });
        }
        // foreach ($items as $item) {
        //     $item->item_images = asset('images') . "/" .$ItemImage->pluck('url')->where('fk_item_id', $item->id);
        // }
        // prd($items);
        
        return $items;
    }
}
/**
 * use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HelperController extends Controller
{
    public static function getItems($condition = [], $groupBy = '', $itemId = '', $admin = false)
    {
        $query = Items::query()
            ->select(
                'items.*',
                'categories.c_description',
                'categories.category_name',
                'products.product_name',
                'products.product_code',
                'products.p_description',
                'products.gender',
                'products.p_keywords',
                'products.status AS p_status',
                'products.priority AS p_priority',
                'colors.color_code',
                'colors.color_name',
                'sizes.size_name',
                'sizes.size_code'
            )
            ->leftJoin('categories', 'items.fk_category_id', '=', 'categories.category_id')
            ->leftJoin('products', 'items.fk_product_id', '=', 'products.product_id')
            ->leftJoin('colors', 'items.fk_color_id', '=', 'colors.color_id')
            ->leftJoin('sizes', 'items.fk_size_id', '=', 'sizes.size_id');

        // Adjust the query based on status
        if ($admin && isAdmin()) {
            $query->where('items.visible', 1);
        }

        // Apply conditions
        foreach ($condition as $field => $value) {
            // Split the condition into operator and value
            $operator = '=';
            if (is_array($value) && count($value) === 2) {
                list($operator, $fieldValue) = $value;
            } else {
                $fieldValue = $value;
            }
            
            // Apply the condition
            switch ($operator) {
                case '=':
                    $query->where($field, '=', $fieldValue);
                    break;
                case '>':
                    $query->where($field, '>', $fieldValue);
                    break;
                case '<':
                    $query->where($field, '<', $fieldValue);
                    break;
                case '!=':
                    $query->where($field, '!=', $fieldValue);
                    break;
                case 'LIKE':
                    $query->where($field, 'LIKE', $fieldValue);
                    break;
                default:
                    // Handle unsupported operators
                    break;
            }
        }

        // Append group by
        if (!empty($groupBy)) {
            $query->groupBy($groupBy);
        }

        // Append itemId
        if (!empty($itemId)) {
            $query->where('items.item_id', $itemId);
        }

        return $query->get();
    }
}

 */