<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Slider;
use Illuminate\Support\Facades\Auth;

class SliderController extends Controller
{
    public function manage_slider(){
        $adminUser = Auth::guard('admin')->user();
        $all_slide = Slider::orderBy('id','DESC')->get();
        return view('admin.slider.list_slider',['user'=>$adminUser])->with(compact('all_slide'));
    }
    public function add_slider(){
        $adminUser = Auth::guard('admin')->user();
        return view('admin.slider.add_slider',['user'=>$adminUser]);
    }
    public function save_slider(Request $request){
        $data = $request->all();
        $slider = new Slider();
        $slider->slider_name = $data['slider_name'];
        $slider->slider_desc = $data['slider_desc'];
        $slider->status = $data['slider_status'];

         //thêm ảnh vào folder 
        $get_image = $request->slider_image;       
        $path = 'public/uploads/slider/';
        $get_name_image = $get_image->getClientOriginalName();
        $name_image = current(explode('.',$get_name_image));
        $new_image = $name_image.rand(0,99).'.'.$get_image->getClientOriginalExtension();
        $get_image -> move($path,$new_image);            
          
        $slider->slider_image = $new_image;
        $slider->save();
        return redirect()->back()->with('status','Thêm slider thành công');
    }
    public function unactive_slider($id){
        Slider::where('id',$id)->update(['status'=>1]);
        return redirect()->back()->with('status','Bạn đã cho hiển thị slide này');
    }
    public function active_slider($id){
        Slider::where('id',$id)->update(['status'=>0]);
        return redirect()->back()->with('status','Bạn đã cho ẩn slide này');
    }
    public function delete_slider($id){
        Slider::where('id',$id)->delete();
        return redirect()->back->with('status','Bạn đã xóa slider thành công');
    }
    public function edit_slider($id){
        $adminUser = Auth::guard('admin')->user();
        $edit_slider = Slider::find($id)->where('id',$id)->get();

        return view('admin.slider.edit_slider',['user'=>$adminUser])->with(compact('edit_slider'));
    }
    public function update_slider(Request $request,$id){
        $data = $request->all();
        $slider = Slider::find($id);
        $slider->slider_name = $data['slider_name'];
        $slider->slider_desc = $data['slider_desc'];
        $slider->status = $data['slider_status'];
         //thêm ảnh vào folder 
        $get_image = $request->slider_image;
        if($get_image){
            $path = 'public/uploads/slider/'.$slider->slider_image;
            if(file_exists($path)){
                unlink($path);
            }
            $path = 'public/uploads/slider/';
            $get_name_image = $get_image->getClientOriginalName();
            $name_image = current(explode('.',$get_name_image));
            $new_image = $name_image.rand(0,99).'.'.$get_image->getClientOriginalExtension();         
            $get_image -> move($path,$new_image);

            $slider->slider_image = $new_image;
        }
        $slider->save();
        return redirect()->back()->with('status','Cập nhật Slider thành công'); 
    }
}
