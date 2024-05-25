<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\Size; // Import Size model

class SizeController extends Controller
{
     public function __invoke()
    {

        $sizes = Size::all();

        return view('admin.sizes', ['sizes' => $sizes]);
    }
    public function add(Request $request)
    {
        // Validate request data
        $request->validate([
            'size_name' => 'required|string',
            'size_code' => 'required|string',
        ]);

        // Create new size instance
        $size = new Size();
        $size->size_name = $request->input('size_name');
        $size->size_code = $request->input('size_code');
        $size->save();

        return response()->json(['status' => 'success']);
    }

    public function update(Request $request)
    {
        // Validate request data
        $request->validate([
            'size_id' => 'required|integer',
            'size_name' => 'required|string',
            'size_code' => 'required|string',
        ]);

        $size_id = $request->input('size_id');

        // Find the size by its custom primary key (size_id)
        $size = size::findOrFail($size_id);
        $size->size_name = $request->input('size_name');
        $size->size_code = $request->input('size_code');
        $size->save();

        return response()->json(['status' => 'success']);
    }

    public function delete(Request $request)
    {
        // Validate request data
        $request->validate([
            'size_id' => 'required|integer',
        ]);

        // Delete size
        $size = size::findOrFail($request->input('size_id'));
        $size->delete();

        return response()->json(['status' => 'success']);
    }
}
