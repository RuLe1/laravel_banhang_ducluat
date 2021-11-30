@extends('admin_layout')
@section('content')

<div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
            Thêm mã giảm giá
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
                    <form role="form" action="{{URL::to('/save-coupon')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="exampleInputEmail1">Tên mã giảm giá</label>
                            <input name="coupon_name" class="form-control" id="exampleInputEmail1" placeholder="Tên mã giảm giá"required>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Code giảm giá</label>
                            <input type="text" name="coupon_code" class="form-control" id="exampleInputEmail1" placeholder="Mã giảm giá"required>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Số lượng mã</label>
                            <input type="text" name="coupon_time" class="form-control" id="exampleInputEmail1" placeholder="Mã giảm giá"required>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Tính năng mã</label>
                            <select name="coupon_condition"class="form-control input-sm m=bot15">
                                <option value="0">----Chọn----</option>
                                <option value="1">Giảm theo phần trăm</option>
                                <option value="2">Giảm theo tiền</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Nhập số % hoặc số tiền giảm</label>
                            <input type="text" name="coupon_number" class="form-control" id="exampleInputEmail1" placeholder="Mã giảm giá"required>
                        </div>
                        <button type="submit"name="add_coupon" class="btn btn-info">Thêm</button>
                    </form>
                </div>

            </div>
        </section>
    </div>

@endsection