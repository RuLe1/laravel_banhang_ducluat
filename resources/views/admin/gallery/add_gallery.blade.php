@extends('admin_layout')
@section('content')

<div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
            Thêm thư viện hình ảnh
            </header>
            <div class="panel-body">
                <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif             
                </div>
                <form action="{{url('/insert-gallery/'.$pro_id)}}"method="POST" enctype="multipart/form-data">
                    @csrf
                <div class="row">
                    <div class="col-md-3">

                    </div>
                    <div class="col-md-6">
                        <input type="file"class="form-control"name="file[]"id="file"accept="image/*"multiple>
                        <span id="error_gallery"></span>
                    </div>
                    <div class="col-md-3">
                        <input type="submit"name="upload"value="Tải ảnh"class="btn btn-success">
                    </div>
                </div>
                </form>
                <input type="hidden"value="{{$pro_id}}"name="pro_id"class="pro_id">
                <form>
                    @csrf
                <div id="load_gallery">
                   
                </div>
                </form>

            </div>
        </section>
    </div>

@endsection