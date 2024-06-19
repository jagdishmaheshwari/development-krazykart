<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\Collection; // Import Color model
use App\Http\Controllers\Admin\ItemsController;

class CollectionController extends Controller
{
    public function __construct(ItemsController $itemsController)
    {
        $this->itemsController = $itemsController;
    }
    public function view()
    {
        $collections = Collection::all();

        return view('admin.collection', ['collections' => $collections]);
    }
    public function show($CollectionId)
    {
        $Item = new ItemsController;
        // $condition = ['item_id' => 1];
        // prd($Item->getItems($conditio,[]));
        $Collection = Collection::where('collection_id', $CollectionId)->first(['collection_id', 'name', 'collection_data']);
        $CollectionData = [];
        if ($Collection) {
            $CollectionData['CollectionId'] = $Collection->collection_id;
            $CollectionData['CollectionName'] = $Collection->name;
            $CollectionData['CollectionData'] = json_decode($Collection->collection_data, true);

            if ($CollectionData['CollectionData']) {
                $CollectionData['Items'] = array_map(function ($id) use ($Item) {
                    if ($id) {
                        return $Item->getItems(['item_id' => $id], [], true)[0];
                    }
                }, $CollectionData['CollectionData']);
            }
        }


        // $CollectionData[$index]['Items'] = array_map(function ($itemId) {
        //     $condition = ['item_id' => $itemId];
        //     $items = $Item->getItems($condition);
        //     return reset($items);
        // }, $CollectionData[$index]['CollectionData']);

        // prd($CollectionData);
        return view('admin.manage_collection', ['CollectionData' => (object) $CollectionData]);
    }
    public function store(Request $request)
    {
        // Validate request data
        $request->validate([
            'collection_name' => 'required|string'
        ]);

        // Create new collection instance
        $collection = new Collection();
        $collection->name = $request->input('collection_name');
        $collection->save();

        return response()->json(['status' => 'success']);
    }
    public function update(Request $request)
    {
        // Validate request data
        $request->validate([
            'collection_id' => 'required|integer',
            'collection_name' => 'required|string'
        ]);

        $collection_id = $request->input('collection_id');

        // Find the collection by its custom primary key (collection_id)
        $collection = Collection::findOrFail($collection_id);
        $collection->name = $request->input('collection_name');
        $collection->save();

        return response()->json(['status' => 'success']);
    }
    public function destroy(Request $request)
    {
        // Validate request data
        $request->validate([
            'collection_id' => 'required|integer',
        ]);

        // Delete Collection
        $Collection = Collection::findOrFail($request->input('collection_id'));
        $Collection->delete();

        return response()->json(['status' => 'success']);
    }
    public function addItem(Request $request){
        $request->validate([
            'item' => 'required|array',
            'collection_id' => 'required|integer'
        ]);
        $collection_id = $request->input('collection_id');
        $collection = Collection::findOrFail($collection_id);
        $collection->collection_data = json_encode($request->input('item'));
        $collection->save();
        return response()->json(['success' => 'Collection data saved successfully!']);
    }
}



// $Collection = new Collection();
// $Collection->name = $request->input('name');
// $Collection->type = $request->input('type');
// $Collection->collection_data = $request->input('collection');
// $Collection->save();
