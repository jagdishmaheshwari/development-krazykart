<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\ItemImage;
use Illuminate\Support\Facades\Storage;

class ItemImageController extends Controller
{
    public function upload(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'item_id' => 'required|integer|exists:items,item_id',
        ]);

        if ($request->file('image')) {
            $filePath = $request->file('image')->store('images', 'public');

            $image = new ItemImage();
            $image->fk_item_id = $request->input('item_id');
            $image->priority = $request->input('priority');
            $image->url = $filePath;
            $image->save();

            return response()->json(['success' => 'Image uploaded successfully!', 'imageUrl' => Storage::url($filePath)]);
        }

        return response()->json(['error' => 'Image upload failed!'], 500);
    }
    public function get(Request $request){
        $request->validate([
            'item_id' => 'required|integer|exists:items,item_id',
        ]);
        $image = new ItemImage();
        $image->select('url');
        $image->where('fk_project_id', 'item_id');
    }
}
