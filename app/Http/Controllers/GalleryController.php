<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Gallery;
use Illuminate\Support\Facades\Auth;

class GalleryController extends Controller
{
    public function add_gallery($id){
        $adminUser = Auth::guard('admin')->user();
        $pro_id = $id;
        return view('admin.gallery.add_gallery',['user'=>$adminUser])->with(compact('pro_id'));
    }
    public function insert_gallery(Request $request, $pro_id){
        $get_image = $request->file('file');
        if($get_image){
            foreach($get_image as $image){
                $get_name_image = $image->getClientOriginalName();
                $name_image = current(explode('.',$get_name_image));
                $path = 'public/uploads/gallery/';
                $new_image = $name_image.rand(0,99).'.'.$image->getClientOriginalExtension();
                $image -> move($path,$new_image);

                $gallery = new Gallery();
                $gallery->gallery_name = $new_image;
                $gallery->gallery_image = $new_image;
                $gallery->product_id = $pro_id;
                $gallery->save();
               
            }
            return redirect()->back()->with('status','Thêm thư viện ảnh thành công');
        }
    }
    public function update_gallery_name(Request $request){
        $gal_id = $request->gal_id;
        $gal_text = $request->gal_text;
        $gallery = Gallery::find($gal_id);
        $gallery->id = $gal_id;
        $gallery->gallery_name = $gal_text;
        $gallery->save();
    }
    public function update_gallery_image(Request $request){
        $get_image = $request->file('file');
        $gal_id = $request->gal_id;
        if($get_image){
            $get_name_image = $get_image->getClientOriginalName();
            $name_image = current(explode('.',$get_name_image));
            $path = 'public/uploads/gallery/';
            $new_image = $name_image.rand(0,99).'.'.$get_image->getClientOriginalExtension();
            $get_image -> move($path,$new_image);

            $gallery = Gallery::find($gal_id);
            unlink('public/uploads/gallery/'.$gallery->gallery_image);
            $gallery->gallery_image = $new_image;
            $gallery->save();
    }
}
    public function delete_gallery(Request $request){
        $gal_id = $request->gal_id;
        $gallery = Gallery::find($gal_id);
        unlink('public/uploads/gallery/'.$gallery->gallery_image);
        $gallery->delete();
    }
    public function select_gallery(Request $request){
        $product_id = $request->pro_id;
        $gallery = Gallery::where('product_id',$product_id)->get();
        $gallery_count = $gallery->count();
        $output = ' <form>
                   
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Thứ tự</th>
                                <th>Tên hình ảnh</th>
                                <th>Hình ảnh</th>
                                <th>Quản lý</th>
                            </tr>
                        </thead>
                        <tbody>';
        if($gallery_count > 0){
            $i = 0;
            foreach($gallery as $key => $gal){
                $i++;
                $output.= '
                            <tr>
                                <td>'.$i.'</td>
                                <td contenteditable class="edit_gal_name"data-gal_id="'.$gal->id.'">'.$gal->gallery_name.'</td>
                                <td>
                                    <img width="200px"height="200px"src="'.url('public/uploads/gallery/'.$gal->gallery_image).'">
                                    <input type="file"class="file_image"style="width:200px"data-gal_id="'.$gal->id.'"
                                        id="file-'.$gal->id.'" name="file" accept="image/*">
                                </td>
                                <td>
                                    <button type="button"data-gal_id="'.$gal->id.'" class="btn btn-xs btn-danger delete-gallery">Xóa</button>
                                </td>
                            </tr>
                            ';
            }
        }else{
            $output.= '<tr>
                            <td colspan="4">Sản phẩm chưa có thư viện ảnh</td>
                        </tr>
                        ';
        }
        $output.='</tbody>
        </table>
        </form>';
        echo $output;
    }
}
