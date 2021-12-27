<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category_Product;
use App\Models\Brand_Product;
use App\Models\Customer;
use App\Models\City;
use App\Models\Coupon;
use App\Models\Province;
use App\Models\Wards;
use App\Models\Feeship;
use App\Models\Order;
use App\Models\Shipping;
use App\Models\OrderDetails;
use App\Models\Slider;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use App\Rules\Captcha;
use Illuminate\Support\Carbon;
use Illuminate\Contracts\Session\Session as SessionSession;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;

use function GuzzleHttp\Promise\all;

class CheckoutController extends Controller
{
    public function confirm_order(Request $request){
        $data = $request->all();
        //get coupon
        // if($data['order_coupon']!='no'){
        //     $coupon = Coupon::where('coupon_code',$data['order_coupon'])->first();
        //     $coupon_mail = $coupon->coupon_code;
        //     $coupon->save(); 
        // }else{
        //     $coupon_mail = 'Không có sử dụng';
        // }
        //end-coupon code
        //get vận chuyển
        $shipping = new Shipping();
        $shipping->shipping_name = $data['shipping_name'];
        $shipping->shipping_address = $data['shipping_address'];
        $shipping->shipping_phone = $data['shipping_phone'];
        $shipping->shipping_email = $data['shipping_email'];
        $shipping->shipping_notes = $data['shipping_notes'];
        $shipping->shipping_method = $data['shipping_method'];
        $shipping->save();

        $shipping_id = $shipping->id;
        $checkout_code = substr(md5(microtime()),rand(0,26),5);

        $order = new Order();
        $order->customer_id = Session::get('id');
        $order->shipping_id = $shipping_id;
        $order->order_status = 1;
        $order->order_code = $checkout_code;

        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $order->created_at = now();
        $order->save();

        if(Session::get('cart')){
            foreach(Session::get('cart') as $key => $cart){
                $order_details = new OrderDetails();
                $order_details->order_code = $checkout_code;
                $order_details->product_id = $cart['id'];
                $order_details->product_name = $cart['product_name'];
                $order_details->product_price = $cart['product_price'];
                $order_details->product_sales_quantity = $cart['product_qty'];
                $order_details->product_coupon = $data['order_coupon'];
                $order_details->product_feeship = $data['order_fee'];
                $order_details->save();
            }
        }
        Session::forget('fee');
        Session::forget('coupon');
        Session::forget('cart');

    //send mail confirm
    // $now = Carbon::now('Asia/Ho_Chi_Minh')->format('d-m-Y H:i:s');
    // $title_mail = "Đơn hàng E-closet xác nhận ngày".''.$now;
    // $customer = Customer::find(Session::get('id'));
    // $data['email'][] = $shipping->shipping_email;
    // //lấy giỏ hàng
    // if(Session::get('cart') == true){
    //     foreach(Session::get('cart') as $key => $cart_mail){
    //         $cart_array[] = array(
    //             'product_name' => $cart_mail['product_name'],
    //             'product_price' => $cart_mail['product_price'],
    //             'product_qty' => $cart_mail['product_qty']
    //         );
    //     }
    // }
    //lấy shipping
    // $shipping_array = array(
    //     //  'customer_name' => $customer->customer_name,
    //      'shipping_name' => $data['shipping_name'],
    //      'shipping_email' => $data['shipping_email'],
    //      'shipping_phone' => $data['shipping_phone'],
    //      'shipping_address' => $data['shipping_address'],
    //      'shipping_notes' => $data['shipping_notes'],
    //      'shipping_method' => $data['shipping_method']
    // );
    //lấy mã giảm giá, lấy mã đơn hàng
    // $ordercode_mail = array(
    //     'coupon_code' => $coupon_mail,
    //     'order_code' => $checkout_code
    // );
    // Mail::send('pages.mail_order',compact('cart_array','shipping_array','ordercode_mail'),
    //     function($message) use ($title_mail,$data){
    //         $message->to($data['email'])->subject($title_mail);
    //         $message->from($data['email'],$title_mail);
    //     });
    }
    public function calculate_fee(Request $request){
        $data = $request->all();
        if($data['matp']){
            $feeship = Feeship::where('fee_matp',$data['matp'])->where('fee_maqh',$data['maqh'])->where('fee_xaid',$data['xaid'])->get();
            if($feeship){
                $count_feeship = $feeship->count();
                if($count_feeship > 0){
                    foreach($feeship as $key => $fee){
                        Session::put('fee',$fee->fee_feeship);
                        Session::save();
                    }
                }else{
                        Session::put('fee',15000);
                        Session::save();
                }
            }
        }
    }
    public function select_delivery_home(Request $request){
        $data = $request->all();
        if($data['action']){
            $output = '';
            if($data['action'] == "city"){
                $select_province = Province::where('matp',$data['ma_id'])->orderBy('maqh','ASC')->get();
                $output.='<option>-----Chọn quận huyện----</option>';
                foreach($select_province as $key => $province){
                    $output.='<option value="'.$province->maqh.'">'.$province->name_quanhuyen.'</option>';
                }
            }else{
                $select_wards = Wards::where('maqh',$data['ma_id'])->orderBy('xaid','ASC')->get();
                $output.='<option>-----Chọn xã phường----</option>';
                foreach($select_wards as $key => $ward){
                    $output.='<option value="'.$ward->xaid.'">'.$ward->name_xaphuong.'</option>';
                } 
            }
        }
        echo $output;
    }
    public function login_checkout(Request $request){
        //seo
        $meta_desc = "Chuyên order KELIFAN cao cấp chính hãng, mới nhất, đẹp nhất, khác biệt nhất";
        $meta_keywords = "thời trang giới trẻ, thời trang hiện đại";
        $meta_title = "E-CLOSET | THỜI TRANG HIỆN ĐẠI | THỜI TRANG CAO CẤP";
        $url_canonical = $request->url();
        //--seo
        $list_category = Category_Product::where('status',1)->orderBy('id','desc')->get();
        $list_brand = Brand_Product::where('status',1)->orderBy('id','desc')->get();
        $slider = Slider::orderBy('id','DESC')->where('status',1)->take(4)->get();

        return view('pages.login_checkout')->with(compact('list_category','list_brand','meta_desc','meta_keywords','meta_title','url_canonical','slider'));
    }
    public function add_customer(Request $request){
        $data = $request->validate([
            'customer_email' => 'unique:customer',
           'g-recaptcha-response' => new Captcha(),
        ],
        [
            'customer_email.unique'=>'Email đã tồn tại, xin nhập tên khác',
        ]
        );
        // $customer = new Customer();
        // $data['customer_name']=  $customer->customer_name;
        // $data['customer_email'] = $customer->customer_email;
        // $data['customer_phone'] = $customer->customer_phone;
        // $data['customer_password'] = md5($customer->customer_password);
        // $customer->save(); 
        $data = array();
        $data['customer_name'] = $request->customer_name;
        $data['customer_email'] = $request->customer_email;
        $data['customer_password']= md5($request->customer_password);
        $data['customer_phone']= $request->customer_phone;

        $customer_id = DB::table('customer')->insertGetId($data);
        Session::put('id',$customer_id);
        Session::put('customer_name',$request->customer_name);

        return redirect()->to('/checkout');
    }
    public function checkout(Request $request){
         //seo
         $meta_desc = "Chuyên order KELIFAN cao cấp chính hãng, mới nhất, đẹp nhất, khác biệt nhất";
         $meta_keywords = "thời trang giới trẻ, thời trang hiện đại";
         $meta_title = "E-CLOSET | THỜI TRANG HIỆN ĐẠI | THỜI TRANG CAO CẤP";
         $url_canonical = $request->url();
         //--seo
        $list_category = Category_Product::where('status',1)->orderBy('id','desc')->get();
        $list_brand = Brand_Product::where('status',1)->orderBy('id','desc')->get();
        $city = City::orderBy('matp','ASC')->get();
        $slider = Slider::orderBy('id','DESC')->where('status',1)->take(4)->get();

       return view('pages.checkout')->with(compact('list_category','list_brand','meta_desc','meta_keywords','meta_title','url_canonical','city','slider'));;
    
    }
    public function save_checkout_customer(Request $request){
        $data = array();
        $data['shipping_name'] = $request->shipping_name;
        $data['shipping_phone'] = $request->shipping_phone;
        $data['shipping_email']= $request->shipping_email;
        $data['shipping_address']= $request->shipping_address;
        $data['shipping_notes']= $request->shipping_note;

        $shipping_id = DB::table('shipping')->insertGetId($data);
        Session::put('shipping_id',$shipping_id);//'shipping_id là tự đặt, ko nằm trong bảng đâu'
       

       return redirect('/payment');
    }
    public function payment(Request $request){
        //seo
        $meta_desc = "Chuyên order KELIFAN cao cấp chính hãng, mới nhất, đẹp nhất, khác biệt nhất";
        $meta_keywords = "thời trang giới trẻ, thời trang hiện đại";
        $meta_title = "E-CLOSET | THỜI TRANG HIỆN ĐẠI | THỜI TRANG CAO CẤP";
        $url_canonical = $request->url();
        //--seo
        $list_category = Category_Product::where('status',1)->orderBy('id','desc')->get();
        $list_brand = Brand_Product::where('status',1)->orderBy('id','desc')->get();

        return view('pages.payment')->with(compact('list_category','list_brand','meta_desc','meta_keywords','meta_title','url_canonical'));

    }
    public function order_place(Request $request){
         //seo
         $meta_desc = "Chuyên order KELIFAN cao cấp chính hãng, mới nhất, đẹp nhất, khác biệt nhất";
         $meta_keywords = "thời trang giới trẻ, thời trang hiện đại";
         $meta_title = "E-CLOSET | THỜI TRANG HIỆN ĐẠI | THỜI TRANG CAO CẤP";
         $url_canonical = $request->url();
         //--seo
        //insert payment method
        $data = array();
        $data['payment_method'] = $request->payment_option;
        $data['payment_status'] = 'Đang chờ xử lý';
       $payment_id = DB::table('payment')->insertGetId($data);
       //insert order
       $order_data = array();
        $order_data['customer_id'] = Session::get('id');
        $order_data['shipping_id'] = Session::get('shipping_id');
        $order_data['payment_id'] = $payment_id;
        $order_data['order_total'] = Cart::total();
        $order_data['order_status'] = 'Đang chờ xử lý';
        $order_id = DB::table('order')->insertGetId($order_data);
        //insert order_details
        $content = Cart::content();
        foreach($content as $v_content){
            $order_d_data = array();
            $order_d_data['order_id'] =  $order_id;
            $order_d_data['product_id'] = $v_content->id;
            $order_d_data['product_name'] = $v_content->name;
            $order_d_data['product_price'] = $v_content->price;
            $order_d_data['product_sales_quantity'] = $v_content->qty;
            DB::table('order_details')->insert($order_d_data);
        }
        if($data['payment_method'] ==1){
            echo 'Thẻ ATM';
        }elseif($data['payment_method'] ==2){
            Cart::destroy();
            $list_category = Category_Product::where('status',1)->orderBy('id','desc')->get();
            $list_brand = Brand_Product::where('status',1)->orderBy('id','desc')->get();
           return view('pages.handcash')->with(compact('list_category','list_brand','meta_desc','meta_keywords','meta_title','url_canonical'));
        }else{
            echo 'Thẻ ghi nợ';
        }
    }
    public function logout_checkout(){
        Session::flush();
        return redirect()->to('/login-checkout');
    }
    public function login_customer(Request $request){
       $email = $request->email_account;
       $password = md5($request->password_account);

       $result = DB::table('customer')->where('customer_email',$email)->where('customer_password',$password)->first();
        if($result){
            Session::put('id',$result->id);
            return redirect()->to('/checkout');
        }else{
            return redirect()->to('/login-checkout');
        }
    }
    public function manage_order(){
        $adminUser = Auth::guard('admin')->user();
        //return view('admin.order.manage_order');
        $all_order = DB::table('order')->join('customer','order.customer_id','=','customer.id')
        ->select('order.*','customer.customer_name')
        ->orderBy('order.id','DESC')->get();
        $manager_order = view('admin.order.manage_order',['user'=>$adminUser])->with(compact('all_order'));
        return view('admin_layout',['user'=>$adminUser])->with(compact('manager_order'));
    }
    public function view_order($orderId){
        $adminUser = Auth::guard('admin')->user();
        $order_by_id = DB::table('order')
        ->join('customer','order.customer_id','=','customer.id')
        ->join('shipping','order.shipping_id','=','shipping.id')
        ->join('order_details','order.id','=','order_details.order_id')
        ->select('order.*','customer.*','shipping.*','order_details.*')->where('order.id',$orderId)->get();
       
        $manager_order_by_id = view('admin.order.view_order',['user'=>$adminUser])->with(compact('order_by_id'));
        return view('admin.order.view_order',['user'=>$adminUser])->with(compact('order_by_id'));
    }
    public function delete_order($orderId){
        Order::where('id',$orderId)->delete();
        return redirect()->back()->with('status','Bạn đã xóa đơn hàng thành công');
    }
}
