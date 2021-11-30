<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category_Product;
use App\Models\Brand_Product;
use App\Models\Coupon;
use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Contracts\Session\Session as SessionSession;
use Illuminate\Support\Facades\Redirect;

class CartController extends Controller
{
    public function gio_hang(Request $request){
         //seo
         $meta_desc = "Chuyên order KELIFAN cao cấp chính hãng, mới nhất, đẹp nhất, khác biệt nhất";
         $meta_keywords = "thời trang giới trẻ, thời trang hiện đại";
         $meta_title = "E-CLOSET | THỜI TRANG HIỆN ĐẠI | THỜI TRANG CAO CẤP";
         $url_canonical = $request->url();
         //--seo
        $list_category = Category_Product::where('status',1)->orderBy('id','desc')->get();
        $list_brand = Brand_Product::where('status',1)->orderBy('id','desc')->get();
        $slider = Slider::orderBy('id','DESC')->where('status',1)->take(4)->get();

        return view('pages.cart_ajax')->with(compact('list_category','list_brand','meta_desc','meta_keywords','meta_title','url_canonical','slider'));
    }
    public function add_cart_ajax(Request $request){
        $data = $request->all();
        $session_id = substr(md5(microtime()),rand(0,26),5);
        $cart = Session::get('cart');
        if($cart==true){
            $is_available = 0;
            foreach($cart as $key=>$val){
                if($val['id'] == $data['cart_product_id']){
                    $is_available++;
                }
            }
            if($is_available == 0){
                $cart[] = array(
                    'session_id'=> $session_id,
                    'id'=> $data['cart_product_id'],
                    'product_name'=> $data['cart_product_name'],
                    'product_image'=> $data['cart_product_image'],
                    'product_qty'=> $data['cart_product_qty'],
                    'product_price'=> $data['cart_product_price'],
                   );
                Session::put('cart',$cart);
            }
        }else{
           $cart[] = array(
            'session_id'=> $session_id,
            'product_name'=> $data['cart_product_name'],
            'id'=> $data['cart_product_id'],
            'product_image'=> $data['cart_product_image'],
            'product_price'=> $data['cart_product_price'],
            'product_qty'=> $data['cart_product_qty'],
           );
           Session::put('cart',$cart);
       } 
       Session::save();
    }
    public function delete_product_ajax($session_id){
        $cart = Session::get('cart');
        if($cart == true){
            foreach($cart as $key => $val){
                if($val['session_id'] == $session_id){
                    unset($cart[$key]);
                }
            }
            Session::put('cart',$cart);
            Session::forget('coupon');
            return redirect()->back()->with('status','Xóa sản phẩm thành công');
        }
    }
    public function update_cart_ajax(Request $request){
        $data = $request->all();
        $cart = Session::get('cart');
        if($cart == true){
            foreach($data['cart_qty'] as $key => $qty){//cart_qty là name của cart_ajax_blade
               foreach($cart as $session => $val){
                   if($val['session_id'] == $key){
                       $cart[$session]['product_qty'] = $qty;//product_qty là cột của table product
                   }
               }
            }
            Session::put('cart',$cart);
            return redirect()->back()->with('status','Cập nhật số lượng sản phẩm thành công');
        }
    }
    public function del_all_product(){
        $cart = Session::get('cart');
        if($cart == true){
            Session::forget('cart');
            Session::forget('coupon');
        return redirect()->back()->with('status','Bạn đã xóa hết sản phẩm trong giỏ hàng');
        }
    }
    public function check_coupon(Request $request){
        $data = $request->all();
        $coupon = Coupon::where('coupon_code',$data['coupon'])->first();
        if($coupon){
            $count_coupon = $coupon->count();
            if($count_coupon > 0){
                $coupon_session = Session::get('coupon');
                if($coupon_session == true){
                    $is_available = 0;
                    if($is_available == 0){
                        $cou[] = array(
                            'coupon_code' => $coupon->coupon_code,
                            'coupon_condition' => $coupon->coupon_condition,
                            'coupon_number' => $coupon->coupon_number,
                        );
                        Session::put('coupon',$cou);
                    }
                }else{
                    $cou[] = array(
                        'coupon_code' => $coupon->coupon_code,
                        'coupon_condition' => $coupon->coupon_condition,
                        'coupon_number' => $coupon->coupon_number,
                    );
                    Session::put('coupon',$cou);
                }
                Session::save();
                return redirect()->back()->with('check_ok','Áp mã giảm giá thành công');
            }
        }else{
            return redirect()->back()->with('check_error','Mã giảm giá không đúng');
        }
    }
    public function unset_coupon(){
        $coupon = Session::get('coupon');
        if($coupon == true){
            Session::forget('coupon');
            return redirect()->back()->with('check_ok','Xóa mã khuyến mãi thành công');
        }
    }
    public function save_cart(Request $request){
        // $list_category = Category_Product::where('status',1)->orderBy('id','desc')->get();
        // $list_brand = Brand_Product::where('status',1)->orderBy('id','desc')->get();
        
        // $productId = $request->productid_hidden;
        // $quantity = $request->qty;

        // $product_info = Product::where('id',$productId)->first();
       
        // $data['id'] = $product_info->id;
        // $data['qty'] = $quantity;
        // $data['name'] = $product_info->product_name;
        // $data['price'] = $product_info->product_price;
        // $data['weight'] = $product_info->product_price;
        // $data['options']['image'] = $product_info->product_image;
        // Cart::add($data);
        // return Redirect::to('/show-cart');
        //Cart::destroy();
    }
    public function show_cart(Request $request){
         //seo
         $meta_desc = "Chuyên order KELIFAN cao cấp chính hãng, mới nhất, đẹp nhất, khác biệt nhất";
         $meta_keywords = "thời trang giới trẻ, thời trang hiện đại";
         $meta_title = "E-CLOSET | THỜI TRANG HIỆN ĐẠI | THỜI TRANG CAO CẤP";
         $url_canonical = $request->url();
         //--seo
        $list_category = Category_Product::where('status',1)->orderBy('id','desc')->get();
        $list_brand = Brand_Product::where('status',1)->orderBy('id','desc')->get();
        return view('pages.show_cart')->with(compact('list_category','list_brand','meta_desc','meta_keywords','meta_title','url_canonical'));
    }
    public function delete_to_cart($rowId){
        Cart::update($rowId,0);
        return Redirect::to('/show-cart');
    }
    public function update_cart_quantity(Request $request){
        $rowId = $request->rowId_cart;
        $qty = $request->cart_quantity;
        Cart::update($rowId,$qty);
        return Redirect::to('/show-cart');
    }
}
