<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Wishkart;

class UserController extends Controller
{
    public function showLoginForm()
    {
        // Check if user is already authenticated
        if (Auth::check()) {
            return redirect()->route('dashboard'); // Redirect to dashboard if user is logged in
        }

        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/dashboard'); // Redirect to intended page after login
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    public function dashboard()
    {
        return view('dashboard', ['ActivePage' => 'profile']);
    }
    public function wishkart()
    {
        return view('wishkart');
    }
    public function logout(Request $request)
    {
        Auth::logout(); // Log the user out

        $request->session()->invalidate(); // Invalidate the session

        $request->session()->regenerateToken(); // Regenerate CSRF token

        return redirect('/'); // Redirect to home page or any desired page after logout
    }
    public function product($ProductId)
    {
        $Product = getItem($ProductId);
        $ActivePage = 'product';
        return view('product', compact('Product', 'ActivePage'));
    }
    public function addToWishkart(Request $request)
    {
        $request->validate([
            'item_id' => 'required|integer',
        ]);
        $user = auth()->user()->id;
        $wishkart = new Wishkart();
        $wishkart->fk_user_id = $user;
        $wishkart->fk_item_id = $request->item_id;

        $wishkart->save();
        return response()->json(['success' => 'Item added to Wishkart successfully']);
    }
    public function showWishkart()
    {
        $userId = auth()->user()->id;

        $wishkartItems = Wishkart::where('fk_user_id', $userId)->get();
        $mappedWishkartItems = $wishkartItems->map(function ($wishkartItem) {
            $itemDetails = getItem($wishkartItem->fk_item_id) ?: '';
            return $itemDetails;
        });
        return view('wishkart', [
            'wishkartItems' => $mappedWishkartItems,
            'ActivePage' => 'wishkart'
        ]);
    }
}




// // app/Http/Controllers/Auth/UserController.php

// namespace App\Http\Controllers\Auth;

// use Illuminate\Http\Request;
// use Auth;

// class UserController extends Controller
// {
//     public function showLoginForm()
//     {
//         return view('auth.login');
//     }

//    public function login(Request $request)
// {
//     $credentials = $request->validate([
//         'email' => 'required|email',
//         'password' => 'required',
//     ]);

//     if (Auth::attempt($credentials)) {
//         // Authentication successful, retrieve authenticated user
//         $user = Auth::user();

//         // Store user_name and user_id in session
//         $request->session()->put('user_name', $user->name); // Assuming 'name' is the user's name column
//         $request->session()->put('user_id', $user->id);

//         // Regenerate session ID to prevent session fixation attacks
//         $request->session()->regenerate();

//         // Redirect to intended page after login
//         return redirect()->intended('/dashboard');
//     }

//     // Authentication failed, redirect back with error message
//     return back()->withErrors([
//         'email' => 'The provided credentials do not match our records.',
//     ]);
// }
    // public function logout(Request $request)
    // {
    //     Auth::logout(); // Log the user out

    //     $request->session()->invalidate(); // Invalidate the session

    //     $request->session()->regenerateToken(); // Regenerate CSRF token

    //     return redirect('/'); // Redirect to home page or any desired page after logout
    // }

//     public function dashboard()
//     {
//         // Retrieve authenticated user
//         $user = Auth::user();

//         // Check if user is authenticated
//         if ($user) {
//             return view('dashboard', ['user' => $user]);
//         } else {
//             // If user is not authenticated, redirect to login
//             return redirect()->route('login');
//         }
//     }
// }
