<?php
// namespace App\Http\Livewire;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Mail;
use App\Mail\VerificationMail;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Auth\UserController;
// use App\Http\Controllers\AdminAuthController;



Route::get('/logout', [UserController::class, 'logout'])->name('logout');

Route::get('/login', [UserController::class, 'showLoginForm'])->name('login');
Route::post('/login', [UserController::class, 'login']);


Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [UserController::class, 'dashboard'])->name('dashboard');
    Route::get('/wishkart', [UserController::class, 'wishkart'])->name('wishkart');
});



Route::view('/', 'home');


use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\ColorController;
use App\Http\Controllers\Admin\SizeController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\ItemsController;
use App\Http\Controllers\Admin\ItemImageController;


Route::get("admin/",function () {
prd('Ok');
});
Route::prefix('admin')->group(function () {
    Route::get('/', function () {return redirect()->route('admin.dashboard');});
    Route::get('/login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
    Route::post('/login', [AdminAuthController::class, 'login']);
    Route::get('logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

    Route::middleware('auth:admin')->group(function () {
        Route::post('/upload-item-image', [ItemImageController::class, 'upload'])->name('item.image.upload');
        Route::get('/dashboard', AdminDashboardController::class)->name('admin.dashboard');
        Route::get('/colors', ColorController::class)->name('admin.colors');
        Route::get('/sizes', SizeController::class)->name('admin.sizes');
    });
});





Route::prefix('admin')->middleware('auth:admin')->group(function () {
    // Color routes
    Route::post('/color/add', [ColorController::class, 'add'])->name('admin.color.add');
    Route::post('/color/update', [ColorController::class, 'update'])->name('admin.color.update');
    Route::post('/color/delete', [ColorController::class, 'delete'])->name('admin.color.delete');



    Route::post('/size/add', [SizeController::class, 'add'])->name('admin.size.add');
    Route::post('/size/update', [SizeController::class, 'update'])->name('admin.size.update');
    Route::post('/size/delete', [SizeController::class, 'delete'])->name('admin.size.delete');



    // Route::post('/category/add', [CategoryController::class, 'add'])->name('admin.category.add');
    // Route::post('/category/update', [CategoryController::class, 'update'])->name('admin.category.update');
    // Route::post('/category/delete', [CategoryController::class, 'delete'])->name('admin.category.delete');
    Route::prefix('categories')->group(function () {
        Route::get('/', CategoryController::class)->name('admin.categories'); 
        Route::post('/', [CategoryController::class, 'store'])->name('admin.categories.add'); // Create a new category
        Route::get('/{c_id}/products', ProductController::class); // Show a specific category
        Route::get('/{c_id}/products/{p_id}/items', ItemsController::class)->name('admin.items.index'); // Show a specific category
        Route::get('/{c_id}/products/{p_id}/item/{i_id}', [ItemsController::class,'view'])->name('admin.item.view'); // Show a specific category
        Route::put('/', [CategoryController::class, 'update'])->name('admin.categories.update'); // Update a category
        Route::delete('/', [CategoryController::class, 'destroy'])->name('admin.categories.delete'); // Delete a category


        // Route::get('/{category}/products/{product}/items', ItemsController::class)->name('admin.items.index');

        
        
    })->name('admin.categories');

    
    Route::prefix('/products')->group(function () {
        // Route::get('/', ProductController::class); // Show all products of a category
        Route::post('/', [ProductController::class,'store'])->name('admin.product.add'); // Create a new product for a category
        // Route::get('/{productId}', 'ProductController@show'); // Show a specific product
        Route::put('/', [ProductController::class,'update'])->name('admin.product.update'); // Update a product
        Route::delete('/', [ProductController::class,'destroy'])->name('admin.product.delete'); // Delete a product
    });
    
     Route::prefix('/items')->group(function () {
        Route::post('/', [ItemsController::class, 'store'])->name('admin.items.add');
        Route::put('/', [ItemsController::class, 'update'])->name('admin.items.update');
        Route::delete('/', [ItemsController::class, 'destroy'])->name('admin.items.delete');
     });
});

Route::get('/ok', function () {
    $items = $this->getItems('', '', '', true);
    
});

use App\Http\Controllers\Admin\HelperController;
Route::post('/admin/update_status', [HelperController::class, 'updateStatus']);
Route::post('/admin/edit_priority', [HelperController::class, 'editPriority']);




// // Route::view('/dashboard', 'dashboard');

// Route::get('/test', function(){
//     $data = session()->all();
//     return $data;
// });


// Route::middleware('auth')->group(function () {
// Route::route('verify-email', 'pages.auth.verify-email')
//     ->name('verification.notice');

// Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)
//     ->middleware(['signed', 'throttle:6,1'])
//     ->name('verification.verify');

// Route::route('confirm-password', 'pages.auth.confirm-password')
//     ->name('password.confirm');
// });

// Route::view('/wishkart', 'wishkart');




// Route::get('/login', function () {
//     // if (auth()->check()) {
//     //     // User is authenticated, redirect to dashboard
//     //     return redirect()->route('dashboard');
//     // } else {
//     //     // User is not authenticated, redirect to login form
//     //     return redirect()->route('login');
//     // }
//     echo "<button wire:click='logout' class='w-full text-start'>
//                             <x-dropdown-link>
//                                 {{ __('Log Out') }}
//                             </x-dropdown-link>
//                         </button>";
// })->middleware('auth'); 


// Route::view('dashboard', 'dashboard')
//     ->middleware(['auth', 'verified'])
//     ->name('dashboard');



// Route::view('profile', 'profile')
//     ->middleware(['auth'])
//     ->name('profile');

// require __DIR__.'/auth.php';




// Route::post('/verify_email', function (Request $request) {
//     try {
//         $validatedData = $request->validate([
//             'email' => 'required|email',
//         ]);
//         $email = $validatedData['email'];
//         Mail::to($email)->send(new VerificationMail());

//         return response()->json(['message' => 'Verification code sent successfully'], 200);
//     } catch (\Exception $e) {
//         return response()->json(['message' => 'Failed to send test email: ' . $e->getMessage()], 500);
//     }
// });


















// Insert Testing data
use Illuminate\Support\Facades\DB;

Route::get('/insert-test-admin', function () {
    // Insert test admin data
    DB::table('admins')->insert([
        'name' => 'Jagdish Maheshwari',
        'email' => 'jagdishmaheshwari57@gmail.com',
        'password' => bcrypt('11111111'), // Encrypt the password (for testing purposes)
        'remember_token' => Str::random(10), // Generate a random remember token
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    return 'Test admin data inserted successfully!';
});

Route::get('/insert-test-user', function () {
    // Insert test admin data
    DB::table('users')->insert([
        'name' => 'Jagdish Maheshwari',
        'email' => 'jagdishmaheshwari57@gmail.com',
        'password' => bcrypt('11111111'), // Encrypt the password (for testing purposes)
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    return 'Test User data inserted successfully!';
});