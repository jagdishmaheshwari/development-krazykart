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
            'images.*' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'item_id' => 'required|integer|exists:items,item_id',
        ]);
        
        $itemId = $request->input('item_id');

        // Count the existing images for the given item_id
        $existingImageCount = ItemImage::where('fk_item_id', $itemId)->count();

        // Get the number of new images being uploaded
        $newImageCount = count($request->file('images'));

        // Check if the total number of images exceeds the limit
        if ($existingImageCount + $newImageCount > 7) {
            return response()->json(['error' => 'Cannot upload more than 7 images for this item.']);
        }
        $imageUrls = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $filePath = $file->store('images', 'public');

                $image = new ItemImage();
                $image->fk_item_id = $request->input('item_id');
                $image->priority = $request->input('priority');
                $image->url = $filePath;
                $image->save();

                $imageUrls[] = Storage::url($filePath);
            }

            return response()->json(['success' => 'Images uploaded successfully!'], 201);
        }

        return response()->json(['error' => 'Image upload failed!'], 500);
    }
    public function get(Request $request)
    {
        $request->validate([
            'item_id' => 'required|integer|exists:items,item_id',
        ]);
        $image = new ItemImage();
        $image->select('url');
        $image->where('fk_project_id', 'item_id');
    }
    public function destroy(Request $request)
    {
        $request->validate([
            'image_id' => 'required|integer|exists:item_images',
            'item_id' => 'required|integer|exists:items',
        ]);

        // Find the item image by its ID
        $image = ItemImage::findOrFail($request->input('image_id'));

        // Delete the image file from storage
        Storage::delete($image->url);

        // Delete the item image from the database
        $image->delete();

        return response()->json(['success' => 'Image deleted successfully!']);
    }
    public function updateImageOrder(Request $request)
    {
        $OrderedImages = $request->imageOrder;
        foreach ($OrderedImages as $order) {
            $image = ItemImage::findOrFail($order['imageId']);

            $image->priority = $order['order'];
            $image->save();
        }
        return response()->json(['success' => 'Images Order Updated Successfull!']);
    }
}
