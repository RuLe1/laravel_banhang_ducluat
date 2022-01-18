@extends('admin_layout')
@section('content')

<div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
            Cập nhật sản phẩm
            </header>
            <div class="panel-body">
                <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif             
                </div>
                @foreach($edit_product as $key => $edit)
                <div class="position-center">
                    <form role="form" action="{{URL::to('/update-product/'.$edit->id)}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="exampleInputEmail1">Tên sản phẩm</label>
                            <input name="product_name" value="{{$edit->product_name}}"class="form-control" id="exampleInputEmail1" placeholder="Tên sản phẩm">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Số lượng</label>
                            <input name="product_quantity" value="{{$edit->product_quantity}}"class="form-control" id="exampleInputEmail1" placeholder="Số lượng sản phẩm">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Giá sản phẩm</label>
                            <input type="text" name="product_price" value="{{$edit->product_price}}"class="form-control" id="exampleInputEmail1" placeholder="Giá sản phẩm">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Hình ảnh sản phẩm</label>
                            <input type="file"name="product_image" class="form-control" id="exampleInputEmail1" placeholder="Hình ảnh sản phẩm">
                            <img src="{{URL::to('public/uploads/product/'.$edit->product_image)}}"width="150"height="150">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Tags sản phẩm</label>
                            <input name="product_tags" value="{{$edit->product_tags}}"class="form-control" id="exampleInputEmail1">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Mô tả sản phẩm</label>
                            <textarea style="resize:none" rows="5" class="form-control"name="product_desc" id="ckeditor_product_desc2" placeholder="Mô tả sản phẩm">{{$edit->product_desc}}
                            </textarea>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Nội dung sản phẩm</label>
                            <textarea style="resize:none" rows="5" class="form-control" name="product_content" id="exampleInputPassword1" placeholder="Nội dung sản phẩm">{{$edit->product_content}}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputFile">Danh mục sản phẩm</label>
                            <select name="product_cate"class="form-control input-sm m=bot15">
                                @foreach($cate_product as $key => $cate)
                                    @if($cate->id == $edit->category_id)
                                        <option selected value="{{$cate->id}}">{{$cate->category_name}}</option>
                                    @else
                                        @foreach($cate_product as $key => $val2)
                                            @if($val2->category_parent == $cate->id)
                                                <option {{$val2->id == $edit->category_parent ? 'selected' :''}} value="{{$val2->id}}">==Danh mục con=={{$val2->category_name}}</option>
                                            @endif
                                        @endforeach
                                    <!-- <option value="{{$cate->id}}">{{$cate->category_name}}</option> -->
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputFile">Thương hiệu sản phẩm</label>
                            <select name="product_brand"class="form-control input-sm m=bot15">
                                @foreach($brand_product as $key => $brand)
                                    @if($brand->id == $edit->brand_id)
                                        <option selected value="{{$brand->id}}">{{$brand->brand_name}}</option>
                                    @else
                                        <option value="{{$brand->id}}">{{$brand->brand_name}}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputFile">Tình trạng</label>
                            <select name="product_status"class="form-control input-sm m=bot15">
                                @if($edit->status == 0)
                                    <option selected value="0">Ẩn</option>
                                    <option value="1">Hiển thị</option>
                                @else
                                    <option value="1">Ẩn</option>
                                    <option selected value="1">Hiển thị</option>
                                @endif
                            </select>
                        </div>
                        <button type="submit"name="update_product" class="btn btn-info">Cập nhật</button>
                    </form>
                </div>
                @endforeach
            </div>
        </section>
    </div>

@endsection