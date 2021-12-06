@extends('admin_layout')
@section('content')

<div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
            Thêm sản phẩm
            </header>
            <div class="panel-body">
                <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif             
                </div>
                <div class="position-center">
                    <form role="form" action="{{URL::to('/save-product')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="exampleInputEmail1">Tên sản phẩm</label>
                            <input name="product_name" class="form-control" id="exampleInputEmail1" placeholder="Tên sản phẩm"required>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Số lượng</label>
                            <input name="product_quantity" class="form-control" id="exampleInputEmail1" placeholder="Số lượng sản phẩm"required>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Giá sản phẩm</label>
                            <input type="text" name="product_price" class="form-control" id="exampleInputEmail1" placeholder="Giá sản phẩm"required>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Hình ảnh sản phẩm</label>
                            <input type="file"name="product_image" class="form-control" id="exampleInputEmail1" placeholder="Hình ảnh sản phẩm"required>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Mô tả sản phẩm</label>
                            <textarea id="ckeditor_product_desc1" style="resize:none" rows="5" class="form-control" name="product_desc" id="exampleInputPassword1" placeholder="Mô tả sản phẩm"required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Nội dung sản phẩm</label>
                            <textarea style="resize:none" rows="5" class="form-control" name="product_content" id="exampleInputPassword1" placeholder="Nội dung sản phẩm"required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputFile">Danh mục sản phẩm</label>
                            <select name="product_cate"class="form-control input-sm m=bot15">
                                @foreach($cate_product as $key => $cate)
                                <option value="{{$cate->id}}">{{$cate->category_name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputFile">Thương hiệu sản phẩm</label>
                            <select name="product_brand"class="form-control input-sm m=bot15">
                                @foreach($brand_product as $key => $brand)
                                    <option value="{{$brand->id}}">{{$brand->brand_name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputFile">Hiển thị</label>
                            <select name="product_status"class="form-control input-sm m=bot15">
                                <option value="0">Ẩn</option>
                                <option value="1">Hiển thị</option>
                            </select>
                        </div>
                        <button type="submit"name="add_product" class="btn btn-info">Thêm</button>
                    </form>
                </div>

            </div>
        </section>
    </div>

@endsection