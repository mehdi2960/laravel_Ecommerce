<?php

use App\Http\Controllers\Admin\AttributeController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CommentController;
use App\Http\Controllers\Admin\CouponController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ProductImageController;
use App\Http\Controllers\Admin\TagController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Home\CartController;
use App\Http\Controllers\Home\CompareController;
use App\Http\Controllers\Home\HomeController;
use App\Http\Controllers\Home\ProductController as HomeProductController;
use App\Http\Controllers\Home\CommentController as HomeCommentController;
use App\Http\Controllers\Home\CategoryController as HomeCategoryController;
use App\Http\Controllers\Home\UserProfileController;
use App\Http\Controllers\Home\WishlistController;
use App\Models\User;
use App\Notifications\OTPSms;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/admin-panel/dashboard', function () {
    return view('admin.dashboard');
})->name('dashboard');

//admin
Route::prefix('admin-panel/management')->name('admin.')->group(function (){
        Route::resource('brands',BrandController::class);
        Route::resource('attributes', AttributeController::class);
        Route::resource('categories', CategoryController::class);
        Route::resource('tags', TagController::class);
        Route::resource('products', ProductController::class);
        Route::resource('banners', BannerController::class);
        Route::resource('comments', CommentController::class);
        Route::resource('coupons', CouponController::class);

        //change Approve
        Route::get('/comments /{comment}/change-approve',[CommentController::class,'changeApprove'])->name('comments.change-approve');

        // Get Category Attributes
        Route::get('/category-attributes/{category}', [CategoryController::class, 'getCategoryAttributes']);

        // Edit Product Image
        Route::get('/products/{product}/images-edit' ,[ProductImageController::class , 'edit'])->name('products.images.edit');
        Route::delete('/products/{product}/images-destroy' ,[ProductImageController::class , 'destroy'])->name('products.images.destroy');
        Route::put('/products/{product}/images-set-primary' ,[ProductImageController::class , 'setPrimary'])->name('products.images.set_primary');
        Route::post('/products/{product}/images-add' ,[ProductImageController::class , 'add'])->name('products.images.add');

        // Edit Product Category
        Route::get('/products/{product}/category-edit' ,[ProductController::class , 'editCategory'])->name('products.category.edit');
        Route::put('/products/{product}/category-update' ,[ProductController::class , 'updateCategory'])->name('products.category.update');

});


//home
Route::get('/',[HomeController::class,'index'])->name('home.index');
Route::get('/categories/{category:slug}',[HomeCategoryController::class,'show'])->name('home.categories.show');
Route::get('/products/{product:slug}',[HomeProductController::class,'show'])->name('home.products.show');

//comments
Route::post('/comments/{product}',[HomeCommentController::class,'store'])->name('home.comments.store');

//Favorite || Wishlist
Route::get('/add-to-wishlist/{product}',[WishlistController::class,'add'])->name('home.wishlist.add');
Route::get('/remove-from-wishlist/{product}',[WishlistController::class,'remove'])->name('home.wishlist.remove');

//Compare
Route::get('/compare', [CompareController::class, 'index'])->name('home.compare.index');
Route::get('/add-to-compare/{product}', [CompareController::class, 'add'])->name('home.compare.add');
Route::get('/remove-from-compare/{product}', [CompareController::class, 'remove'])->name('home.compare.remove');

//Cart
Route::get('/cart', [CartController::class, 'index'])->name('home.cart.index');
Route::post('/add-to-cart', [CartController::class, 'add'])->name('home.cart.add');
Route::get('/remove-from-cart/{rowId}', [CartController::class, 'remove'])->name('home.cart.remove');
Route::put('/cart', [CartController::class, 'update'])->name('home.cart.update');
Route::get('/clear-cart', [CartController::class, 'clear'])->name('home.cart.clear');


//Route::get('/login/{provider}',[AuthController::class,'redirectToProvider'])->name('provider.login');
//Route::get('/login/{provider}/callback',[AuthController::class,'handleProviderCallback']);

//OtpSms
Route::any('/login' , [AuthController::class , 'login'])->name('login');
Route::post('/check-otp' , [AuthController::class , 'checkOtp']);
Route::post('/resend-otp' , [AuthController::class , 'resendOtp']);


//Profile
Route::prefix('profile')->name('home.')->group(function () {
    Route::get('/',[UserProfileController::class,'index'])->name('users_profile.index');
    Route::get('/comments',[HomeCommentController::class,'UsersProfileIndex'])->name('comments.users_profile.index');
    Route::get('/wishlist',[WishlistController::class,'UsersProfileIndex'])->name('wishlist.users_profile.index');

});

//Route::get('/test', function () {
//
// $user = User::find(1);
// $user->notify(new OTPSms(1234));
//
//});

