@extends('admin_layout')
@section('content')

<div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
            Cập nhật thương hiệu sản phẩm
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
                    <form role="form" action="{{URL::to('/update-brand-product/'.$edit_brand->id)}}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="exampleInputEmail1">Tên thương hiệu</label>
                            <input type="text" value="{{$edit_brand->brand_name}}"name="brand_product_name" 
                            class="form-control" id="exampleInputEmail1" placeholder="Tên thương hiệu">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Mô tả thương hiệu</label>
                            <textarea style="resize:none" rows="5" class="form-control" name="brand_product_desc"
                             id="exampleInputPassword1" placeholder="Mô tả thương hiệu">{{$edit_brand->brand_desc}}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputFile">Hiển thị</label>
                            <select name="brand_product_status"class="form-control input-sm m=bot15">
                                <option value="0">Ẩn</option>
                                <option value="1">Hiển thị</option>
                            </select>
                        </div>
                        <button type="submit"name="update_brand_product" class="btn btn-info">Cập nhật</button>
                    </form>
                </div>
             
            </div>
        </section>
    </div>

@endsection