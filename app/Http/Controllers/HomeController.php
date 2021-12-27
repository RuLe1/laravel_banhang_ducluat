<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category_Product;
use App\Models\Brand_Product;
use App\Models\Product;
use App\Models\Slider;
use Illuminate\Support\Facades\Mail;
class HomeController extends Controller
{
    // public function send_mail(){
    //     $to_name = "E-Closet";
    //     $to_email = "holuat162@gmail.com";

    //     $data = array("name"=>"Mail từ Shop E-Closet","body"=>"Mail gửi xác nhận bạn đặt hàng");
    
    //     Mail::send('pages.send_mail',$data,function($message) use ($to_name,$to_email){
    //         $message->to($to_email)->subject('test mail nhé');
    //         $message->from($to_email,$to_name);
    //     });
    //     return redirect('/')->with('message','');

    // }
    public function index(Request $request){
        //seo
        $meta_desc = "Chuyên order KELIFAN cao cấp chính hãng, mới nhất, đẹp nhất, khác biệt nhất";
        $meta_keywords = "thời trang giới trẻ, thời trang hiện đại";
        $meta_title = "E-CLOSET | THỜI TRANG HIỆN ĐẠI | THỜI TRANG CAO CẤP";
        $url_canonical = $request->url();
        //--seo
        $list_category = Category_Product::where('status',1)->orderBy('id','desc')->get();
        $list_brand = Brand_Product::where('status',1)->orderBy('id','desc')->get();

        $list_product = Product::with('categoryproduct','brandproduct')->where('status',1)->orderBy('id','DESC')->take(6)->get();
        $slider = Slider::orderBy('id','DESC')->where('status',1)->take(4)->get();
        return view('pages.home')->with(compact('list_category','list_brand','list_product','meta_desc','meta_keywords','meta_title','url_canonical','slider'));
    }
    public function search(Request $request){
        //seo
        $meta_desc = "Chuyên order KELIFAN cao cấp chính hãng, mới nhất, đẹp nhất, khác biệt nhất";
        $meta_keywords = "thời trang giới trẻ, thời trang hiện đại";
        $meta_title = "E-CLOSET | THỜI TRANG HIỆN ĐẠI | THỜI TRANG CAO CẤP";
        $url_canonical = $request->url();
        //--seo
        $list_category = Category_Product::where('status',1)->orderBy('id','desc')->get();
        $list_brand = Brand_Product::where('status',1)->orderBy('id','desc')->get();

        $slider = Slider::orderBy('id','DESC')->where('status',1)->take(4)->get();

        $keywords = $request->keywords_submit;
        $search_product = Product::where('product_name','LIKE','%'.$keywords.'%')->get();
        return view('pages.search')->with(compact('list_category','list_brand','meta_desc','meta_keywords','meta_title','url_canonical','slider','search_product'));
    }
}
