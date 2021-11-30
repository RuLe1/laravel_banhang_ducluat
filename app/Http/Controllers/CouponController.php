<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Coupon;

class CouponController extends Controller
{
    public function list_coupon(){
        $adminUser = Auth::guard('admin')->user();
        $list_coupon = Coupon::orderBy('id','DESC')->get();
        return view('admin.coupon.list_coupon',['user'=>$adminUser])->with(compact('list_coupon'));
    }
    public function delete_coupon($id){
        Coupon::where('id',$id)->delete();
        return redirect()->back()->with('status','Bạn đã xóa mã giảm giá thành công');
    }
    public function insert_coupon(){
        $adminUser = Auth::guard('admin')->user();
        return view('admin.coupon.insert_coupon',['user'=>$adminUser]);
    }
    public function save_coupon(Request $request){
       
        $data = $request->all();

        $coupon = new Coupon();

        $coupon->coupon_name = $data['coupon_name'];
        $coupon->coupon_code = $data['coupon_code'];
        $coupon->coupon_time = $data['coupon_time'];
        $coupon->coupon_condition = $data['coupon_condition'];
        $coupon->coupon_number = $data['coupon_number'];
        $coupon->save();
        return redirect()->back()->with('status','Thêm mã giảm giá thành công');
    }
}
