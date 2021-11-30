<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Category_Product;
use App\Models\Brand_Product;
use App\Models\Product;
use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class CategoryProduct extends Controller
{
    public function add_category_product(){
        $adminUser = Auth::guard('admin')->user();
        return view('admin.category.add_category_product',['user'=>$adminUser]);
    }
    public function all_category_product(){
        $adminUser = Auth::guard('admin')->user();
        $list_category = Category_Product::orderBy('id','desc')->get();
        return view('admin.category.all_category_product',['user'=>$adminUser])->with(compact('list_category'));
    }
   
    public function save_category_product(Request $request){
        $data=array();
        $data['category_name'] = $request->category_product_name;
        $data['category_desc'] = $request->category_product_desc;
        $data['meta_keywords'] = $request->category_product_keywords;
        $data['status'] = $request->category_product_status;
        DB::table('category_product')->insert($data);
        return redirect()->back()->with('status','Thêm danh mục sản phẩm thành công');
    }
    public function unactive_category_product($id){
        Category_Product::where('id',$id)->update(['status'=>1]);
        return redirect()->back()->with('status','Bạn đã cho hiển thị danh mục');
    }
    public function active_category_product($id){
        Category_Product::where('id',$id)->update(['status'=>0]);
        return redirect()->back()->with('status','Bạn đã cho ẩn danh mục');
    }
    public function edit_category_product($id){
        $adminUser = Auth::guard('admin')->user();
        $edit_category = Category_Product::find($id)->where('id',$id)->get();

        return view('admin.category.edit_category_product',['user'=>$adminUser])->with(compact('edit_category'));
    }
    public function update_category_product(Request $request,$id){
        $data=array();
        $data['category_name'] = $request->category_product_name;
        $data['category_desc'] = $request->category_product_desc;
        $data['meta_keywords'] = $request->category_product_keywords;

        DB::table('category_product')->where('id',$id)->update($data);
        return redirect()->back()->with('status','Cập nhật danh mục sản phẩm thành công');
    }
    public function delete_category_product($id){
        Category_Product::where('id',$id)->delete();
        return redirect::to('all-category-product')->with('status','Bạn đã xóa danh mục thành công');
    }
    //end function for Admin page
    public function show_category(Request $request,$id){
         //seo
         $meta_desc = "Chuyên order KELIFAN cao cấp chính hãng, mới nhất, đẹp nhất, khác biệt nhất";
         $meta_keywords = "thời trang giới trẻ, thời trang hiện đại";
         $meta_title = "E-CLOSET | THỜI TRANG HIỆN ĐẠI | THỜI TRANG CAO CẤP";
         $url_canonical = $request->url();
         //--seo
        $list_category = Category_Product::where('status',1)->orderBy('id','desc')->get();
        $list_brand = Brand_Product::where('status',1)->orderBy('id','desc')->get();
        $slider = Slider::orderBy('id','DESC')->where('status',1)->take(4)->get();

        $product_from_category = Product::where('category_id',$id)->orderBy('id','DESC')->get();
        $category_name = Category_Product::where('id',$id)->take(1)->get();
        return view('pages.show_category')->with(compact('list_category','list_brand','product_from_category','category_name','meta_desc','meta_keywords','meta_title','url_canonical','slider'));
    }
   
}
