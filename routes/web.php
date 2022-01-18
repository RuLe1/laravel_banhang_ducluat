<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CategoryProduct;
use App\Http\Controllers\BrandProduct;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\DeliveryController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\SliderController;
use App\Http\Controllers\MailController;
use App\Http\Controllers\GalleryController;

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;

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
//Client Side
Route::get('/',[HomeController::class,'index']);
Route::get('/trang-chu',[HomeController::class,'index']);
Route::post('/tim-kiem',[HomeController::class,'search']);

//Danh mục,thương hiệu,sản phẩm trang chủ
Route::get('/danh-muc-san-pham/{id}',[CategoryProduct::class,'show_category']);
Route::get('/thuong-hieu-san-pham/{id}',[BrandProduct::class,'show_brand']);
//chi tiết sản phẩm
Route::get('/chi-tiet-san-pham/{id}',[ProductController::class,'details_product']);
Route::get('/tag/{product_tag}',[ProductController::class,'tag']);
//Cart
Route::post('/save-cart',[CartController::class,'save_cart']);
Route::get('/show-cart',[CartController::class,'show_cart']);
Route::get('/delete-to-cart/{rowId}',[CartController::class,'delete_to_cart']);
Route::post('/update-cart-quantity',[CartController::class,'update_cart_quantity']);
//Cart Ajax
Route::post('/add-cart-ajax',[CartController::class,'add_cart_ajax']);
Route::get('/gio-hang',[CartController::class,'gio_hang']);
Route::get('/delete-product-ajax/{session_id}',[CartController::class,'delete_product_ajax']);
Route::post('/update-cart-ajax',[CartController::class,'update_cart_ajax']);
Route::get('/del-all-product',[CartController::class,'del_all_product']);
//Coupon
Route::post('/check-coupon',[CartController::class,'check_coupon']);
Route::get('/unset-coupon',[CartController::class,'unset_coupon']);

//checkout
Route::get('/login-checkout',[CheckoutController::class,'login_checkout']);
Route::post('/add-customer',[CheckoutController::class,'add_customer']);
Route::get('/checkout',[CheckoutController::class,'checkout']);
Route::post('/save-checkout-customer',[CheckoutController::class,'save_checkout_customer']);
Route::get('/logout-checkout',[CheckoutController::class,'logout_checkout']);
Route::post('/login-customer',[CheckoutController::class,'login_customer']);
Route::get('/payment',[CheckoutController::class,'payment']);
Route::post('/order-place',[CheckoutController::class,'order_place']);
Route::post('/select-delivery-home',[CheckoutController::class,'select_delivery_home']);
Route::post('/calculate-fee',[CheckoutController::class,'calculate_fee']);
Route::post('/confirm-order',[CheckoutController::class,'confirm_order']);
//Send Mail
Route::get('/send-mail',[CheckoutController::class,'confirm_order']);


//Admin Site
Route::get('/admin',[AdminController::class,'index']);
Route::post('/admin',[AdminController::class,'login']);
Route::get('/logout',[AdminController::class,'logout'])->name('admin.logout');

Route::middleware(['admin'])->group(function(){
    Route::get('/dashboard',[AdminController::class,'dashboard'])->name('admin.dashboard');
    //category product
    Route::get('/add-category-product',[CategoryProduct::class,'add_category_product']);
    Route::get('/all-category-product',[CategoryProduct::class,'all_category_product']);
    Route::get('/edit-category-product/{id}',[CategoryProduct::class,'edit_category_product']);
    Route::get('/delete-category-product/{id}',[CategoryProduct::class,'delete_category_product']);
    Route::post('/update-category-product/{id}',[CategoryProduct::class,'update_category_product']);

    Route::post('/save-category-product',[CategoryProduct::class,'save_category_product']);

    Route::get('/unactive-category-product/{id}',[CategoryProduct::class,'unactive_category_product']);
    Route::get('/active-category-product/{id}',[CategoryProduct::class,'active_category_product']);

    Route::post('/export-csv-category',[CategoryProduct::class,'export_csv_category']);
    Route::post('/import-csv-category',[CategoryProduct::class,'import_csv_category']);

    //brand product
    Route::get('/add-brand-product',[BrandProduct::class,'add_brand_product']);
    Route::get('/all-brand-product',[BrandProduct::class,'all_brand_product']);
    Route::get('/edit-brand-product/{id}',[BrandProduct::class,'edit_brand_product']);
    Route::get('/delete-brand-product/{id}',[BrandProduct::class,'delete_brand_product']);
    Route::post('/update-brand-product/{id}',[BrandProduct::class,'update_brand_product']);

    Route::post('/save-brand-product',[BrandProduct::class,'save_brand_product']);

    Route::get('/unactive-brand-product/{id}',[BrandProduct::class,'unactive_brand_product']);
    Route::get('/active-brand-product/{id}',[BrandProduct::class,'active_brand_product']);
    //product
    Route::get('/add-product',[ProductController::class,'add_product']);
    Route::get('/all-product',[ProductController::class,'all_product']);
    Route::get('/edit-product/{id}',[ProductController::class,'edit_product']);
    Route::get('/delete-product/{id}',[ProductController::class,'delete_product']);
    Route::post('/update-product/{id}',[ProductController::class,'update_product']);

    Route::post('/save-product',[ProductController::class,'save_product']);

    Route::get('/unactive-product/{id}',[ProductController::class,'unactive_product']);
    Route::get('/active-product/{id}',[ProductController::class,'active_product']);

    Route::post('/export-csv-product',[ProductController::class,'export_csv_product']);
    Route::post('/import-csv-product',[ProductController::class,'import_csv_product']);
    //manage order
    Route::get('/manage-order',[OrderController::class,'manage_order']);
    Route::get('/view-order/{order_code}',[OrderController::class,'view_order']);
    Route::get('/print-order/{checkout_code}',[OrderController::class,'print_order']);
    Route::post('/update-order-qty',[OrderController::class,'update_order_qty']);
    Route::post('/update-qty',[OrderController::class,'update_qty']);

    // Route::get('/delete-order/{orderId}',[OrderController::class,'delete_order']);
    //Coupon
    Route::get('/insert-coupon',[CouponController::class,'insert_coupon']);
    Route::post('/save-coupon',[CouponController::class,'save_coupon']);
    Route::get('/list-coupon',[CouponController::class,'list_coupon']);
    Route::get('/delete-coupon/{id}',[CouponController::class,'delete_coupon']);
    //Send Coupon
    Route::get('/send-coupon-vip',[MailController::class,'send_coupon_vip']);
    Route::get('/send-coupon',[MailController::class,'send_coupon']);

    //Vận chuyển
    Route::get('/delivery',[DeliveryController::class,'delivery']);
    Route::post('/select-delivery',[DeliveryController::class,'select_delivery']);
    Route::post('/insert-delivery',[DeliveryController::class,'insert_delivery']);
    Route::post('/select-feeship',[DeliveryController::class,'select_feeship']);
    Route::post('/update-delivery',[DeliveryController::class,'update_delivery']);
    //Slider
    Route::get('/manage-slider',[SliderController::class,'manage_slider']);
    Route::get('/add-slider',[SliderController::class,'add_slider']);
    Route::post('/save-slider',[SliderController::class,'save_slider']);
    Route::get('/unactive-slider/{id}',[SliderController::class,'unactive_slider']);
    Route::get('/active-slider/{id}',[SliderController::class,'active_slider']);
    Route::get('/delete-slider/{id}',[SliderController::class,'delete_slider']);
    Route::get('/edit-slider/{id}',[SliderController::class,'edit_slider']);
    Route::post('/update-slider/{id}',[SliderController::class,'update_slider']);
    //Gallery
    Route::get('/add-gallery/{id}',[GalleryController::class,'add_gallery']);
    Route::post('/select-gallery',[GalleryController::class,'select_gallery']);
    Route::post('/insert-gallery/{pro_id}',[GalleryController::class,'insert_gallery']);
    Route::post('/update-gallery-name',[GalleryController::class,'update_gallery_name']);
    Route::post('/delete-gallery',[GalleryController::class,'delete_gallery']);
    Route::post('/update-gallery-image',[GalleryController::class,'update_gallery_image']);

});
//Login  google
Route::get('/login-google',[LoginController::class,'login_google']);
Route::get('/google/callback',[LoginController::class,'callback_google']);
//Login facebook
Route::get('/login-facebook',[LoginController::class,'login_facebook']);
Route::get('/admin/callback',[LoginController::class,'callback_facebook']);

Route::get('/test',[LoginController::class,'test']);
 


