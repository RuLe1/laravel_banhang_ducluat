<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Models\Customer;
use App\Models\Coupon;
use Illuminate\Support\Carbon;

class MailController extends Controller
{
    public function send_coupon(){
        //get customer
        $customer = Customer::where('customer_vip','=',NULL)->get();
        echo $now = Carbon::now('Asia/Ho_Chi_Minh')->format('d-m-Y H:i:s');
        $title_mail = "Mã khuyến mãi ngày".''.$now;
        $data = [];
        foreach($customer as $vip){
            $data['email'][] = $vip->customer_email;
        }
        Mail::send('pages.send_coupon',$data,function($message) use ($title_mail,$data){
            $message->to($data['email'])->subject($title_mail);
            $message->from($data['email'],$title_mail);
        });
        return redirect()->back()->with('status','Gửi mã khuyến mãi khách thường thành công');
    }
    public function send_coupon_vip(){
        //get customer
        $customer_vip = Customer::where('customer_vip',1)->get();
        echo $now = Carbon::now('Asia/Ho_Chi_Minh')->format('d-m-Y H:i:s');
        $title_mail = "Mã khuyến mãi ngày".''.$now;
        $data = [];
        foreach($customer_vip as $vip){
            $data['email'][] = $vip->customer_email;
        }
        Mail::send('pages.send_coupon_vip',$data,function($message) use ($title_mail,$data){
            $message->to($data['email'])->subject($title_mail);
            $message->from($data['email'],$title_mail);
        });
        return redirect()->back()->with('status','Gửi mã khuyến mãi khách Vip thành công');
    }
}
