<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\InventoryController;
use Illuminate\Http\Request;
use App\Models\Admin\Inventory;
use Illuminate\Support\Facades\Session;
use App\Models\Admin\Items;




class InventoryController extends Controller
{
    public function StockAjax(Request $request)
    {
        $action = $request->input('action');

        // Dynamically call the method based on the action parameter
        if (method_exists($this, $action)) {
            return $this->$action($request);
        } else {
            return response()->json(['success' => false, 'message' => 'Invalid action!']);
        }
    }
    public function AddStock(Request $request)
    {
        $request->validate([
            'stockLocation' => 'required|string|max:255',
            'quantity' => 'required|integer',
            'vendor' => 'nullable|string|max:255',
            'remark' => 'nullable|string|max:512',
            'itemId' => 'required|integer|exists:items,item_id', // assuming items table exists
        ]);

        $adminId = Session::get('admin_id');
        // Create a new Inventory record
        $Inventory = new Inventory();
        $item = new Items();
        $item = Items::find($request->input('itemId'));
        $item->increment('stock', $request->input('quantity'));
        $item->save();

        $Inventory->fk_item_id = $request->input('itemId');
        $Inventory->fk_admin_id = $adminId;
        $Inventory->location = $request->input('stockLocation');
        $Inventory->quantity = $request->input('quantity');
        $Inventory->vendor = $request->input('vendor');
        $Inventory->remark = $request->input('remark');
        $Inventory->created_at = now();

        $Inventory->save();

        return response()->json(['success' => 'Stock Added Successfull!']);
    }
    public function getItemStockModalData(Request $request)
    {
        $request->validate([
            'itemId' => 'required|integer|exists:items,item_id'
        ]);

        // Retrieve the item by its ID
        $item = Items::findOrFail($request->input('itemId'));

        // Get the available quantity of the item
        $availableQuantity = $item->stock;

        return response()->json(['count' => $availableQuantity]);
    }

    public function ProductWiseStockView()
    {
        $products =  ItemsController::getItems([], [], true);
        return view('admin.manage_stock',compact('products'));
    }
    public function ItemWiseStockView(Request $request)
    {
        $items = ItemsController::getItems(['p.product_id' => $request->id], [], true);
        return view('admin.manage_stock_item_wise', compact('items'));
    }
    // public function StockViewAjax()
    // {
    //     $products = ItemsController::getItems([], [], true);
    //     $data = [];

    //     foreach ($products as $row) {
    //         $data[] = [
    //             'image' => isset($products['item_images']) && $products['item_images'] ? reset($products['item_images']) : "/img/image-placeholder-300-500.jpg",
    //             'product_name' => $row->product_name,
    //             'stock' => $row->stock
    //         ];
    //     }

    //     return response()->json(['data' => $data]);
    // }
}
