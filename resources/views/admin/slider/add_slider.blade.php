@extends('admin_layout')
@section('content')

<div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
            Thêm hình ảnh Slider
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
                    <form role="form" action="{{URL::to('/save-slider')}}" method="POST"enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="exampleInputEmail1">Tên slider</label>
                            <input name="slider_name" class="form-control" id="exampleInputEmail1" placeholder="Tên slider"required>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Hình ảnh</label>
                            <input type="file"name="slider_image" class="form-control" id="exampleInputEmail1" placeholder="Hình ảnh"required>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Mô tả slider</label>
                            <textarea style="resize:none" rows="5" class="form-control" name="slider_desc" id="exampleInputPassword1" placeholder="Mô tả slider"required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputFile">Hiển thị</label>
                            <select name="slider_status"class="form-control input-sm m=bot15">
                                <option value="0">Ẩn</option>
                                <option value="1">Hiển thị</option>
                            </select>
                        </div>
                        <button type="submit"name="add_slider" class="btn btn-info">Thêm</button>
                    </form>
                </div>

            </div>
        </section>
    </div>

@endsection