<?php
// namespace App\Http\Livewire;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Mail;
use App\Mail\VerificationMail;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\Auth\UserController;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\ColorController;
use App\Http\Controllers\Admin\SizeController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CollectionController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\ItemsController;
use App\Http\Controllers\Admin\ItemImageController;
use App\Http\Controllers\Admin\HelperController;
use App\Http\Controllers\Admin\InventoryController;
use App\Http\Controllers\HomePage;
use Illuminate\Http\Request;

Route::get('/logout', [UserController::class, 'logout'])->name('logout');

Route::get('/login', [UserController::class, 'showLoginForm'])->name('login');
Route::post('/login', [UserController::class, 'login'])->name('user.login');
Route::get('/lang/{locale}', [LanguageController::class, 'switchLang'])->name('lang.switch');
Route::get('/product/{p_id}', [UserController::class, 'product'])->name('product.view');
Route::post('/wishkart/add', [UserController::class, 'addToWishkart'])->name('wishkart.add');


Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [UserController::class, 'dashboard'])->name('dashboard');
    Route::get('/wishkart', [UserController::class, 'showWishkart'])->name('wishkart');
});
Route::get('/', HomePage::class)->name('home');

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/', function () {return redirect()->route('admin.dashboard');});
    Route::get('/login', [AdminAuthController::class, 'showLoginForm'])->name('login.form');
    Route::post('/login', [AdminAuthController::class, 'login'])->name('login');
    Route::get('/logout', [AdminAuthController::class, 'logout'])->name('logout');

    Route::middleware('auth:admin')->group(function () {
        Route::post('/upload-item-image', [ItemImageController::class, 'upload'])->name('item.image.upload');
        Route::delete('/upload-item-image', [ItemImageController::class, 'destroy'])->name('item.image.delete');
        Route::get('/dashboard', AdminDashboardController::class)->name('dashboard');

        Route::get('/colors', ColorController::class)->name('colors');
        Route::post('/color/add', [ColorController::class, 'add'])->name('color.add');
        Route::post('/color/update', [ColorController::class, 'update'])->name('color.update');
        Route::post('/color/delete', [ColorController::class, 'delete'])->name('color.delete');
        
        
        
        Route::get('/sizes', SizeController::class)->name('sizes');
        Route::post('/size/add', [SizeController::class, 'add'])->name('size.add');
        Route::post('/size/update', [SizeController::class, 'update'])->name('size.update');
        Route::post('/size/delete', [SizeController::class, 'delete'])->name('size.delete');

        Route::prefix('categories')->group(function () {
            Route::get('/', CategoryController::class)->name('categories'); 
            Route::post('/', [CategoryController::class, 'store'])->name('categories.add'); // Create a new category
            Route::post('/list', [CategoryController::class, 'getCategoryListAjax'])->name('categories.list.ajax'); // Create a new category
            Route::get('/{c_id}/products', ProductController::class)->name('product.view'); // Show a specific category
            Route::get('/{c_id}/products/{p_id}/items', ItemsController::class)->name('items.index'); // Show a specific category
            Route::get('/{c_id}/products/{p_id}/item/{i_id}', [ItemsController::class,'view'])->name('item.view'); // Show a specific category
            Route::put('/', [CategoryController::class, 'update'])->name('categories.update'); // Update a category
            Route::delete('/', [CategoryController::class, 'destroy'])->name('categories.delete'); // Delete a category
        });

        Route::prefix('collection')->group(function () {
            Route::get('/', [CollectionController::class, 'view'])->name('collection');
            Route::post('/', [CollectionController::class, 'store'])->name('collection.add');
            Route::post('/add-item', [CollectionController::class, 'addItem'])->name('collection.item.add');
            Route::put('/', [CollectionController::class, 'update'])->name('collection.update');
            Route::get('/{c_id}', [CollectionController::class, 'show'])->name('collection.show');
            Route::delete('/', [CollectionController::class, 'destroy'])->name('collection.delete');
        });

        Route::prefix('/products')->group(function () {
            Route::post('/', [ProductController::class,'store'])->name('product.add'); // Create a new product for a category
            Route::post('/product_detail', [ProductController::class,'GetProductHtml'])->name('product.html'); // Create a new product for a category
            Route::put('/', [ProductController::class,'update'])->name('product.update'); // Update a product
            Route::post('/list', [ProductController::class, 'getProductListAjax'])->name('product.list.ajax');
            Route::delete('/', [ProductController::class,'destroy'])->name('product.delete'); // Delete a product
            // Route::get('/', ProductController::class); // Show all products of a category
            // Route::get('/{productId}', 'ProductController@show'); // Show a specific product
        });
        
        Route::prefix('/items')->group(function () {
            Route::post('/', [ItemsController::class, 'store'])->name('items.add');
            Route::post('/clone', [ItemsController::class, 'cloneItem'])->name('item.clone');
            Route::put('/', [ItemsController::class, 'update'])->name('items.update');
            Route::post('/list', [ItemsController::class, 'getItemListAjax'])->name('items.list.ajax');
            Route::delete('/', [ItemsController::class, 'destroy'])->name('items.delete');
        });


        Route::put('update-image-order', [ItemImageController::class , 'updateImageOrder'])->name('item.image.order');
        Route::post('get-item-images', function (Request $request) {
            $itemId = $request->input('item_id');
            // $imageUrls = getItemImages($itemId);

            $imageUrls = [];
            foreach(getItemImages($itemId) as $imageId => $Url){
                $imageUrls[][$imageId] = $Url;
            }
            return response()->json(['image_urls' => $imageUrls]);
        })->name('item.images');
        Route::post('/update_status', [HelperController::class, 'updateStatus']);
        Route::post('/edit_priority', [HelperController::class, 'editPriority']);


        // Route::get('/getitem', function () {$items = $this->getItems('', '', true);});

        Route::post("/stock-ajax", [InventoryController::class, 'StockAjax'])->name('stock.ajax');

        Route::get("stock", [InventoryController::class, 'ProductWiseStockView'])->name('stock.view');
        Route::get("stock/{id}", [InventoryController::class, 'ItemWiseStockView'])->name('stock.view.itemwise');
        Route::post("stock", [InventoryController::class, 'StockViewAjax'])->name('stock.view.ajax');

        Route::get('/seed-data', function () {
            Artisan::call('db:seed', ['--class' => 'ItemsSeeder']);
            return 'TIME - ' . now() . '<br>  ||   Available categories : '. DB::table('categories')->selectRaw('COUNT(*) as count')->get()->first()->count . '<br>  ||   Available Products : ' . DB::table('products')->selectRaw('COUNT(*) as count')->get()->first()-> count . '<br>  ||   Available Items : ' . DB::table('items')->selectRaw('COUNT(*) as count')->get()->first()->count;
        });
    });
});

Route::post('/verify_email', function (Request $request) {
    try {
        $validatedData = $request->validate([
            'email' => 'required|email',
        ]);
        $email = $validatedData['email'];
        Mail::to($email)->send(new VerificationMail());

        return response()->json(['success' => 'Verification code sent successfully'], 200);
    } catch (\Exception $e) {
        return response()->json(['message' => 'Failed to send test email: ' . $e->getMessage()], 500);
    }
});





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

    return 'Test Admin Created!';
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

    return 'Test User Created!';
});

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


