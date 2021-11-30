<?php

namespace App\Http\Controllers;

use App\Models\Brand_Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use App\Models\Category_Product;
use App\Models\Product;
use App\Models\Slider;

class BrandProduct extends Controller
{
    public function add_brand_product(){
        $adminUser = Auth::guard('admin')->user();
        return view('admin.brand.add_brand_product',['user'=>$adminUser]);
    }
    public function all_brand_product(){
        $adminUser = Auth::guard('admin')->user();
        $list_brand = Brand_Product::orderBy('id','desc')->get();
        return view('admin.brand.all_brand_product',['user'=>$adminUser])->with(compact('list_brand'));
    }
   
    public function save_brand_product(Request $request){
        $data = $request->all();
        $brand = new Brand_Product();
        $brand->brand_name = $data['brand_product_name'];
        $brand->brand_desc = $data['brand_product_desc'];
        $brand->status = $data['brand_product_status'];

        $brand->save();
        // $data=array();
        // $data['brand_name'] = $request->brand_product_name;
        // $data['brand_desc'] = $request->brand_product_desc;
        // $data['status'] = $request->brand_product_status;
        // DB::table('brand_product')->insert($data);
        return redirect()->back()->with('status','Thêm thương hiệu sản phẩm thành công');
    }
    public function unactive_brand_product($id){
        Brand_Product::where('id',$id)->update(['status'=>1]);
        return redirect()->back()->with('status','Bạn đã cho hiển thị thương hiệu');
    }
    public function active_brand_product($id){
        Brand_Product::where('id',$id)->update(['status'=>0]);
        return redirect()->back()->with('status','Bạn đã cho ẩn thương hiệu');
    }
    public function edit_brand_product($id){
        $adminUser = Auth::guard('admin')->user();
        $edit_brand = Brand_Product::find($id);

        return view('admin.brand.edit_brand_product',['user'=>$adminUser])->with(compact('edit_brand'));
    }
    public function update_brand_product(Request $request,$id){
        $data = $request->all();

        $brand = Brand_Product::find($id);
        $brand->brand_name = $data['brand_product_name'];
        $brand->brand_desc = $data['brand_product_desc'];
        $brand->status = $data['brand_product_status'];

        $brand->save();
        // $data=array();
        // $data['brand_name'] = $request->brand_product_name;
        // $data['brand_desc'] = $request->brand_product_desc;
        // DB::table('brand_product')->where('id',$id)->update($data);
        return redirect()->back()->with('status','Cập nhật thương hiệu sản phẩm thành công');
    }
    public function delete_brand_product($id){
        Brand_Product::where('id',$id)->delete();
        return redirect::to('all-brand-product')->with('status','Bạn đã xóa thương hiệu thành công');
    }
    //end of Admin page
    public function show_brand(Request $request,$id){
         //seo
         $meta_desc = "Chuyên order KELIFAN cao cấp chính hãng, mới nhất, đẹp nhất, khác biệt nhất";
         $meta_keywords = "thời trang giới trẻ, thời trang hiện đại";
         $meta_title = "E-CLOSET | THỜI TRANG HIỆN ĐẠI | THỜI TRANG CAO CẤP";
         $url_canonical = $request->url();
         //--seo
        $list_category = Category_Product::where('status',1)->orderBy('id','desc')->get();
        $list_brand = Brand_Product::where('status',1)->orderBy('id','desc')->get();
        $slider = Slider::orderBy('id','DESC')->where('status',1)->take(4)->get();

        $product_from_brand = Product::where('brand_id',$id)->orderBy('id','DESC')->get();
        $brand_name = Brand_Product::where('id',$id)->take(1)->get();

        return view('pages.show_brand')->with(compact('list_category','list_brand','product_from_brand','brand_name','meta_desc','meta_keywords','meta_title','url_canonical','slider'));
    }
}
