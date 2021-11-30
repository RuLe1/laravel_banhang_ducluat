@extends('admin_layout')
@section('content')

<div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
            Cập nhật Slide
            </header>
            <div class="panel-body">
                <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif             
                </div>
                @foreach($edit_slider as $key => $edit)
                <div class="position-center">
                    <form role="form" action="{{URL::to('/update-slider/'.$edit->id)}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="exampleInputEmail1">Tên slider</label>
                            <input name="slider_name" value="{{$edit->slider_name}}"class="form-control" id="exampleInputEmail1" placeholder="Tên sản phẩm">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Hình ảnh</label>
                            <input type="file"name="slider_image" class="form-control" id="exampleInputEmail1" placeholder="Hình ảnh sản phẩm">
                            <img src="{{URL::to('public/uploads/slider/'.$edit->slider_image)}}"width="150"height="150">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Mô tả slider</label>
                            <textarea style="resize:none" rows="5" class="form-control"name="slider_desc" id="ckeditor_product_desc2" placeholder="Mô tả sản phẩm">{{$edit->slider_desc}}
                            </textarea>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputFile">Tình trạng</label>
                            <select name="slider_status"class="form-control input-sm m=bot15">
                                @if($edit->status == 0)
                                    <option selected value="0">Ẩn</option>
                                    <option value="1">Hiển thị</option>
                                @else
                                    <option value="1">Ẩn</option>
                                    <option selected value="1">Hiển thị</option>
                                @endif
                            </select>
                        </div>
                        <button type="submit"name="update_slider" class="btn btn-info">Cập nhật</button>
                    </form>
                </div>
                @endforeach
            </div>
        </section>
    </div>

@endsection