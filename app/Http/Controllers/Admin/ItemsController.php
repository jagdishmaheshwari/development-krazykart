<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\Product;
use App\Models;
use App\Models\Admin\Category;
use App\Models\Admin\Items;
use App\Models\Admin\ItemImage;
use App\Models\Admin\Color;
use App\Models\Admin\Size;
use Illuminate\Support\Facades\DB;


class ItemsController extends Controller
{
    public function __invoke($categoryId, $productId)
    {
        $condition = [
            'c.category_id' => $categoryId,
            'p.product_id' => $productId
        ];

        // $products = $this->getItems($condition, '', true);

        $sizes = Size::all();
        $colors = Color::all();
        $products = Product::all();
        $categories = Category::all();
        // $items = Items::where('fk_product_id', $productId)->orderBy('priority')->get();

        $items = $this->getItems($condition, [], true);
        $ProductName = getColumnValueByPrimaryKey('products', 'product_name', ['product_id', $productId]);
        $CategoryName = getColumnValueByPrimaryKey('categories', 'category_name', ['category_id', getColumnValueByPrimaryKey('products', 'fk_category_id', ['product_id', $productId])]);
        
        return view('admin.items', compact('items', 'categoryId', 'productId', 'categories', 'colors', 'sizes', 'products', 'CategoryName','ProductName',));
    }
    public function view($categoryId, $productId, $itemId)
    {
        $condition = [
            'items.fk_category_id' => $categoryId,
            'items.fk_product_id' => $productId,
            'items.item_id' => $itemId
        ];
        $items = $this->getItems($condition, [], true);
        return view('admin.item', compact('items', 'itemId'));
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
            'costPrice' => 'numeric',
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
        $item->cost_price = $request->input('costPrice');
        $item->priority = $request->input('priority');
        $item->save();
        return response()->json(['status' => 'success', 'message' => 'Item Addedd Sucessfull!']);
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
            'costPrice' => 'numeric',
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
        $item->cost_price = $request->input('costPrice');
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
    public function getItemListAjax()
    {
        $productId = $_POST['productId'];
        $items = Items::select(
            'items.item_id',
            DB::raw('(SELECT img.url
                FROM item_images img
                WHERE img.fk_item_id = items.item_id 
                ORDER BY items.priority ASC
                LIMIT 1) AS image_url')
        )->where('items.fk_product_id', $productId)->get();
        return response()->json($items);
    }
    public function cloneItem(Request $request)
    {
        $originalItemId = $request->input('itemId');

        DB::beginTransaction();

        try {
            $originalItem = Items::find($originalItemId);

            if (!$originalItem) {
                return response()->json(['error' => 'Item not found'], 404);
            }

            $newItem = $originalItem->replicate();
            $newItem->save();

            $originalImages = ItemImage::where('fk_item_id', $originalItemId)->get();

            foreach ($originalImages as $originalImage) {
                $newImage = $originalImage->replicate();
                $newImage->fk_item_id = $newItem->item_id;
                $newImage->save();
            }

            DB::commit();

            return response()->json(['success' => 'Item '. $newItem->item_id .' cloned successfull!', 'new_item_id' => $newItem->id], 200);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    /** To get the items
     * @param condition array 
     * @param groupBy string table column name 
     * @param orderBy Array   
     * @param admin Bool
     */
    public static function getItems($condition = [], $orderBy = [], $admin = false)
    {
        $query = DB::table('Items')
            ->select(
                'items.*',
                'c.c_description',
                'c.category_id',
                'c.category_name',
                'p.product_name',
                'p.product_id',
                'p.product_code',
                'p.p_description',
                'p.gender',
                'p.p_keywords',
                'p.status AS p_status',
                'p.priority AS p_priority',
                'colors.color_code',
                'colors.color_name',
                'sizes.size_name',
                'sizes.size_code'
            )
            ->leftJoin('products AS p', 'items.fk_product_id', '=', 'p.product_id')
            ->leftJoin('categories AS c', 'items.fk_category_id', '=', 'c.category_id')
            ->leftJoin('colors', 'items.fk_color_id', '=', 'colors.color_id')
            ->leftJoin('sizes', 'items.fk_size_id', '=', 'sizes.size_id');

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


        $orderBy = $orderBy != null ? $orderBy : ['items.priority asc'];
        foreach ($orderBy as $order) {
            [$column, $direction] = explode(' ', trim($order));
            $query->orderBy($column, $direction);
        }
        $items = $query->get()->toArray();

        // Process the items to include image URLs as arrays
        foreach ($items as $item) {
            $item->item_images = getItemImages($item->item_id);
        }
        // foreach ($items as $item) {
        //     $item->item_images = asset('images') . "/" .$ItemImage->pluck('url')->where('fk_item_id', $item->id);
        // }
        // prd($items);
        
        return $items;
    }
}
/*
 * use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HelperController extends Controller
{
    public static function getItems($condition = [], $itemId = '', $admin = false)
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