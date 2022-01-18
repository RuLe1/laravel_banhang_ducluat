<?php
namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category_Product;
use App\Models\Brand_Product;
use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use App\Models\Gallery;
use File;
use App\Imports\ImportProduct;
use App\Exports\ExportProduct;
use Excel;
class ProductController extends Controller
{
    public function add_product(){
        $adminUser = Auth::guard('admin')->user();
        $cate_product = Category_Product::orderBy('id','DESC')->get();
        $brand_product = Brand_Product::orderBy('id','DESC')->get();
        return view('admin.product.add_product',['user'=>$adminUser])->with(compact('cate_product','brand_product'));
    }
    public function all_product(){
        $adminUser = Auth::guard('admin')->user();
        $list_product = Product::with('categoryproduct','brandproduct')->orderBy('id','DESC')->get();
        return view('admin.product.all_product',['user'=>$adminUser])->with(compact('list_product'));
    }
   
    public function save_product(Request $request){
        $data=array();
        $data['product_name'] =  $request->product_name;
        $data['product_quantity'] =  $request->product_quantity;
        $data['product_price'] =  $request->product_price;
        $data['product_desc'] =  $request->product_desc;
        $data['product_content'] = $request->product_content;
        $data['category_id'] = $request->product_cate;
        $data['brand_id'] = $request->product_brand;
        $data['status'] = $request->product_status;
        $data['product_tags'] = $request->product_tags;
        //thêm ảnh vào folder 
        $path = 'public/uploads/product/';
        $path_gallery = 'public/uploads/gallery/';
        $get_image = $request->file('product_image');
        if($get_image){
            $get_name_image = $get_image->getClientOriginalName();
            $name_image = current(explode('.',$get_name_image));
            $new_image = $name_image.rand(0,99).'.'.$get_image->getClientOriginalExtension();
            $get_image -> move($path,$new_image);
            File::copy($path.$new_image,$path_gallery.$new_image);
            $data['product_image'] = $new_image;
        }
        $pro_id = DB::table('product')->insertGetId($data);

        $gallery = new Gallery();
        $gallery->gallery_image = $new_image;
        $gallery->gallery_name = $new_image;
        $gallery->product_id = $pro_id;
        $gallery->save();

        return redirect()->back()->with('status','Thêm sản phẩm thành công');
    }
    public function unactive_product($id){
        Product::where('id',$id)->update(['status'=>1]);
        return redirect()->back()->with('status','Bạn đã cho hiển thị sản phẩm');
    }
    public function active_product($id){
        Product::where('id',$id)->update(['status'=>0]);
        return redirect()->back()->with('status','Bạn đã cho ẩn sản phẩm');
    }
    public function edit_product($id){
        $adminUser = Auth::guard('admin')->user();
        $cate_product = Category_Product::orderBy('id','DESC')->get();
        $brand_product = Brand_Product::orderBy('id','DESC')->get();
        $edit_product = Product::find($id)->where('id',$id)->get();

        return view('admin.product.edit_product',['user'=>$adminUser])->with(compact('edit_product','cate_product','brand_product'));
    }
    public function update_product(Request $request,$id){
        $data = $request->all();
        $product = Product::find($id);
        $product->product_name =  $data['product_name'];
        $product->product_quantity = $data['product_quantity'];
        $product->product_price =  $data['product_price'];
        $product->product_desc =  $data['product_desc'];
        $product->product_content = $data['product_content'];
        $product->category_id = $data['product_cate'];
        $product->brand_id = $data['product_brand'];
        $product->status = $data['product_status'];
        $product->product_tags = $data['product_tags'];

         //thêm ảnh vào folder 
        $get_image = $request->product_image;
        if($get_image){
             $path = 'public/uploads/product/'.$product->product_image;
             if(file_exists($path)){
                 unlink($path);
            }
            $path = 'public/uploads/product/';
            $get_name_image = $get_image->getClientOriginalName();
            $name_image = current(explode('.',$get_name_image));
            $new_image = $name_image.rand(0,99).'.'.$get_image->getClientOriginalExtension();         
            $get_image -> move($path,$new_image);

            $product->product_image = $new_image;           
        }
        $product->save();
        return redirect()->back()->with('status','Cập nhật sản phẩm thành công');
    }
    public function delete_product($id){
        Product::where('id',$id)->delete();
        return redirect::to('all-product')->with('status','Bạn đã xóa sản phẩm thành công');
    }
    public function export_csv_product(){
        return Excel::download(new ExportProduct , 'product.xlsx');
    }
    public function import_csv_product(Request $request){
        $path = $request->file('file')->getRealPath();
        Excel::import(new ImportProduct,$path);
        return back();
    }
//end of Admin page
    public function details_product(Request $request,$id){
        //seo
        $meta_desc = "Chuyên order KELIFAN cao cấp chính hãng, mới nhất, đẹp nhất, khác biệt nhất";
        $meta_keywords = "thời trang giới trẻ, thời trang hiện đại";
        $meta_title = "E-CLOSET | THỜI TRANG HIỆN ĐẠI | THỜI TRANG CAO CẤP";
        $url_canonical = $request->url();
        //--seo
        $slider = Slider::orderBy('id','DESC')->where('status',1)->take(4)->get();
        $list_category = Category_Product::where('status',1)->orderBy('id','desc')->get();
        $list_brand = Brand_Product::where('status',1)->orderBy('id','desc')->get();
        $details_product = Product::with('categoryproduct','brandproduct')->where('id',$id)->get();
        foreach($details_product as $key => $value){
            $category_id = $value->category_id;
            $product_id = $value->id;
        }
        $gallery = Gallery::where('product_id',$product_id)->get();

        $related_product = DB::table('product')->join('category_product','category_product.id','=','product.category_id')
        ->join('brand_product','brand_product.id','=','product.brand_id')->where('category_product.id',$category_id)
        ->whereNotIn('product.id',[$id])->get();
    
        return view('pages.show_details')->with(compact('category_id','list_category','list_brand','details_product','related_product','meta_desc','meta_keywords','meta_title','url_canonical','slider','gallery'));
    }
    public function tag(Request $request,$product_tag){
        echo 'Trả về sản phẩm bài viết liên quan đến từ: '.$request->product_tag;
    }
}
