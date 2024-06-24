<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Admin\Collection; // Import Color model
use Illuminate\Http\Request;

class HomePage extends Controller
{
    public function __invoke(Request $request)
    {
        // $Data = getItem(2, true);
        $Collection = Collection::where('name', "Homepage Carousel")->first(['collection_id', 'name', 'collection_data']);
        $HomeCarouselData = [];
        if ($Collection && isset($Collection->collection_data) && $Collection->collection_data != null) {
            $HomeCarouselData['Items'] = array_map(function ($id) {
                if ($id) {
                    return getItem($id, true);
                }
            }, json_decode($Collection->collection_data, true));
        }
        // dd((array)$request);
        // prd($HomeCarouselData);
        $Collection = Collection::where('name', "Famous Item Carousel Home")->first(['collection_id', 'name', 'collection_data']);
        $FamousItemCarouselData = [];
        if ($Collection && isset($Collection->collection_data) && $Collection->collection_data != null) {
            $FamousItemCarouselData['Items'] = array_map(function ($id) {
                if ($id) {
                    return getItem($id, true);
                }
            }, json_decode($Collection->collection_data, true));
        }
        $ActivePage = 'home';
        return view('home', compact('HomeCarouselData', 'FamousItemCarouselData', 'ActivePage'));
    }
}
