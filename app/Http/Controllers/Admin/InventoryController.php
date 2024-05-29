<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
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
    public function AddStock(Request $request){
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
        $Inventory->fk_item_id = $request->input('itemId');
        $Inventory->fk_admin_id = $adminId;
        $Inventory->location = $request->input('stockLocation');
        $Inventory->quantity = $request->input('quantity');
        $Inventory->vendor = $request->input('vendor');
        $Inventory->remark = $request->input('remark');
        $Inventory->created_at = now();
        
        $Inventory->save();
        
        return response()->json(['status' => 'success']);
    }
    public function getItemStockModalData(Request $request){
        $request->validate([
            'itemId' => 'required|integer|exists:items,item_id'
        ]);

        // Retrieve the item by its ID
        $item = Items::findOrFail($request->input('itemId'));

        // Get the available quantity of the item
        $availableQuantity = $item->stock;

        return response()->json(['count' => $availableQuantity]);
    }
}
