<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\Color; // Import Color model

class ColorController extends Controller
{
    public function __invoke(){
        $colors = Color::all();

        // Pass colors data to the view
        return view('admin.colors', ['colors' => $colors]);
    }
    public function add(Request $request)
    {
        // Validate request data
        $request->validate([
            'colorName' => 'required|string',
            'colorCode' => 'required|string',
        ]);

        // Create new color instance
        $color = new Color();
        $color->color_name = $request->input('colorName');
        $color->color_code = $request->input('colorCode');
        $color->save();

        return response()->json(['status' => 'success']);
    }

    public function update(Request $request)
    {
        // Validate request data
        $request->validate([
            'colorId' => 'required|integer',
            'colorName' => 'required|string',
            'colorCode' => 'required|string',
        ]);

        $colorId = $request->input('colorId');

        // Find the color by its custom primary key (color_id)
        $color = Color::findOrFail($colorId);
        $color->color_name = $request->input('colorName');
        $color->color_code = $request->input('colorCode');
        $color->save();

        return response()->json(['status' => 'success']);
    }

    public function delete(Request $request)
    {
        // Validate request data
        $request->validate([
            'colorId' => 'required|integer',
        ]);

        // Delete color
        $color = Color::findOrFail($request->input('colorId'));
        $color->delete();

        return response()->json(['status' => 'success']);
    }
}
