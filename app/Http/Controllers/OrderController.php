<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Shipping;
use App\Models\OrderDetails;
use App\Models\Feeship;
use App\Models\Customer;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Dompdf\Adapter\PDFLib;

class OrderController extends Controller
{
    public function update_qty(Request  $request){
        $data = $request->all();
        $order_details = OrderDetails::where('product_id',$data['order_product_id'])->where('order_code',$data['order_code'])->first();
        $order_details ->product_sales_quantity = $data['order_qty'];
        $order_details->save();
    }
    public function update_order_qty(Request $request){
        //update order status
        $data = $request->all();
        $order = Order::find($data['order_id']);
        $order->order_status = $data['order_status'];
        $order->save();
        
        if($order->order_status == 2){
            foreach($data['order_product_id'] as $key => $product_id){
                $product = Product::find($product_id);
                $product_quantity = $product->product_quantity;
                $product_sold = $product->product_sold;
                foreach($data['quantity'] as $key2 => $qty){
                    if($key == $key2){
                        $pro_remain = $product_quantity - $qty;
                        $product->product_quantity = $pro_remain;
                        $product->product_sold = $product_sold + $qty;
                        $product->save();
                    }
                }
            }
        }elseif($order->order_status != 2 && $order->order_status != 1){
            foreach($data['order_product_id'] as $key => $product_id){
                $product = Product::find($product_id);
                $product_quantity = $product->product_quantity;
                $product_sold = $product->product_sold;
                foreach($data['quantity'] as $key2 => $qty){
                    if($key == $key2){
                        $pro_remain = $product_quantity + $qty;
                        $product->product_quantity = $pro_remain;
                        $product->product_sold = $product_sold - $qty;
                        $product->save();
                    }
                }
            }
        }
    }
    public function manage_order(){
        $adminUser = Auth::guard('admin')->user();
        $order = Order::orderBy('created_at','DESC')->get();
        return view('admin.order.manage_order',['user'=>$adminUser])->with(compact('order'));
    }
    public function view_order($order_code){
        $adminUser = Auth::guard('admin')->user();
        $order_details = OrderDetails::where('order_code',$order_code)->get();

        $order = Order::where('order_code',$order_code)->get();
        foreach($order as $key => $ord){
            $customer_id = $ord->customer_id;
            $shipping_id = $ord->shipping_id;
            $order_status = $ord->order_status;
        }
        $customer = Customer::where('id',$customer_id)->first();
        $shipping = Shipping::where('id',$shipping_id)->first();

        $order_details_product = OrderDetails::with('product')->where('order_code',$order_code)->get();
        foreach($order_details_product as $key => $order_d){
            $product_coupon = $order_d->product_coupon;
        }
        if($product_coupon !='Không có'){
            $coupon = Coupon::where('coupon_code',$product_coupon)->first();
            $coupon_condition = $coupon->coupon_condition;
            $coupon_number = $coupon->coupon_number;
        }else{
            $coupon_condition = 2;
            $coupon_number = 0;
        }
        return view('admin.order.view_order',['user'=>$adminUser])->with(compact('order_details_product','order_details','order','customer','shipping','coupon_condition','coupon_number','order_status'));
    }
    public function print_order($checkout_code){
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($this->print_order_convert($checkout_code));
        return $pdf->stream();
    }
    public function print_order_convert($checkout_code){
        $order_details = OrderDetails::where('order_code',$checkout_code)->get();

        $order = Order::where('order_code',$checkout_code)->get();
        foreach($order as $key => $ord){
            $customer_id = $ord->customer_id;
            $shipping_id = $ord->shipping_id;
        }
        $customer = Customer::where('id',$customer_id)->first();
        $shipping = Shipping::where('id',$shipping_id)->first();

        $order_details_product = OrderDetails::with('product')->where('order_code',$checkout_code)->get();
        foreach($order_details_product as $key => $order_d){
            $product_coupon = $order_d->product_coupon;
        }
        if($product_coupon !='Không có'){
            $coupon = Coupon::where('coupon_code',$product_coupon)->first();

            $coupon_condition = $coupon->coupon_condition;
            $coupon_number = $coupon->coupon_number;

            if($coupon_condition == 1){
                $coupon_echo = $coupon_number.'%';
            }elseif($coupon_condition == 2){
                $coupon_echo = number_format($coupon_number,0,',','.').'đ';
            }
        }else{
            $coupon_condition = 2;
            $coupon_number = 0;
            $coupon_echo = '0';
        }
        $output = '';
        $output.='
            <style>
                body{
                    font-family: DejaVu Sans;
                }
                .table-styling{
                    border: 1px solid #000;
                }
                .table-styling > thead > tr > th{
                    border: 1px solid #000;
                } 
                .table-styling > tbody > tr > td{
                    border: 1px solid #000;
                }  
            </style>
            <h1><center>Shop Quần Áo Chính Hãng E-Closet</center></h1>
            <h4><center><i>Giá rẻ - Chất lượng - Chính hãng</i></center></h4>
            <table class="table-styling">
                <thead>
                    <tr>
                        <th>Tên khách đặt</th>
                        <th>Số điện thoại</th>
                        <th>Email</th>
                    </tr>
                <thead>
                <tbody>';          
                $output.='
                    <tr>
                        <td>'.$customer->customer_name.'</td>
                        <td>'.$customer->customer_phone.'</td>
                        <td>'.$customer->customer_email.'</td>

                    </tr>';
                $output.='
                </tbody>
            </table>     
        ';
        $output.='<br><br>';
        $output.='
        <table class="table-styling">
                <thead>
                    <tr>
                        <th>Tên người nhận hàng</th>
                        <th>Số điện thoại</th>
                        <th>Địa chỉ</th>
                        <th>Email</th>
                        <th>Ghi chú</th>

                    </tr>
                <thead>
                <tbody>';          
                $output.='
                    <tr>
                        <td>'.$shipping->shipping_name.'</td>
                        <td>'.$shipping->shipping_phone.'</td>
                        <td>'.$shipping->shipping_address.'</td>
                        <td>'.$shipping->shipping_email.'</td>
                        <td>'.$shipping->shipping_notes.'</td>

                    </tr>';
                $output.='
                </tbody>
            </table>';  
            $output.='<br><br>';
            $output.='
            <table class="table-styling">
                <thead>
                    <tr>
                        <th>Tên sản phẩm</th>
                        <th>Số lượng</th>
                        <th>Giá sản phẩm</th>
                        <th>Thành tiền</th>
                    </tr>
                <thead>
                <tbody>';
                $total = 0;
               
                foreach($order_details_product as $key => $product){
                    $subtotal = $product->product_price * $product->product_sales_quantity;
                    $total += $subtotal;
                    // if($product->product_coupon !='Không có'){
                    //     $product_coupon = $product->product_coupon;
                    // }else{
                    //     $product_coupon = 'Không mã';
                    // }
                    $output.='
                    <tr>
                        <td>'.$product->product_name.'</td>
                        <td>'.$product->product_sales_quantity.'</td>
                        <td>'.number_format($product->product_price,0,',','.').'đ</td>
                        <td>'.number_format($subtotal,0,',','.').'đ</td>
                    </tr>';
                }
                if($coupon_condition == 1){
                    $total_using_coupon = ($total * $coupon_number)/100;
                    $total_coupon = $total -  $total_using_coupon;//$total_coupon là bẳng tổng tiền sp trừ cho tiền giảm giá
                }else{
                    $total_coupon = $total - $coupon_number;
                } 
                $output.='
                    <tr>
                        <td colspan="4">
                            <p>Tạm tính: '.number_format($total,0,',','.').'đ</p>
                            <p>Tiền mã giảm giá: - '.$coupon_echo.'</p>
                            <p>Phí ship: '.number_format($product->product_feeship,0,',','.').'đ</p>
                            <p><b>Tổng thanh toán: '.number_format($total_coupon + $product->product_feeship,0,',','.').'đ</b></p>

                        </td>
                    </tr>
                ';
            $output.='
                </tbody>
        </table><br>';
        $output.='
               <table>
                    <thead>
                        <tr>
                            <th width="200px">Người lập phiếu</th>
                            <th width="800px">Người nhận</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td style="text-align:center"width="200px">Ký tên</td>
                            <td style="text-align:center"width="800px">Ký tên</td>
                        </tr>
                    </tbody>
               </table>        
        ';
        return $output;
    }
}
