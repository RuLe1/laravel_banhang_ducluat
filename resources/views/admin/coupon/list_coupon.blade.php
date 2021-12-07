@extends('admin_layout')
@section('content')
<div class="table-agile-info">
  <div class="panel panel-default">
    <div class="panel-heading">
        Liệt kê mã giảm giá
    </div>
    <div class="row w3-res-tb">
      <div class="col-sm-5 m-b-xs">
        <p><a href="{{url('/send-coupon-vip')}}"class="btn btn-info">Gửi mã giảm giá khách Vip</a></p>
        <p><a href="{{url('/send-coupon')}}"class="btn btn-info">Gửi mã giảm giá khách thường</a></p>
      </div>
      <div class="col-sm-4">
      </div>
      <div class="col-sm-3">
        <div class="input-group">
          <input type="text" class="input-sm form-control" placeholder="Search">
          <span class="input-group-btn">
            <button class="btn btn-sm btn-default" type="button">Go!</button>
          </span>
        </div>
      </div>
    </div>
    <div class="card-body">
          @if (session('status'))
              <div class="alert alert-success" role="alert">
                  {{ session('status') }}
              </div>
          @endif             
      </div>
    <div class="table-responsive">
      <table class="table table-striped b-t b-light">
        <thead>
          <tr>
            <th style="width:20px;">
              <label class="i-checks m-b-none">
                <input type="checkbox"><i></i>
              </label>
            </th>
            <th><b>Tên mã giảm giá</b></th>
            <th><b>Code mã giảm giá</b></th>
            <th><b>Số lượng mã</b></th>
            <th><b>Tính năng mã giảm giá</b></th>
            <th><b>Số tiền, % giảm giá</b></th>
            <th><b>Ngày tạo</b></th>
            <th style="width:30px;"></th>
          </tr>
        </thead>
        <tbody>
          @foreach($list_coupon as $key => $cou)
          <tr>
            <td><label class="i-checks m-b-none"><input type="checkbox" name="post[]"><i></i></label></td>
            <td>{{$cou->coupon_name}}</td>
            <td>{{$cou->coupon_code}}</td>           
            <td>{{$cou->coupon_time}}</td>           
            <td>
              @if($cou->coupon_condition == 1)
                Giảm theo phần trăm
              @else
                Giảm theo tiền
              @endif
            </td>
            <td>{{$cou->coupon_number}}</td>           
            <td><span class="text-ellipsis">12/5/2019</span></td>
            <td>
              <a onclick="return confirm('Bạn chắc chắn muốn xóa coupon {{$cou->coupon_name}} không?')"href="{{URL::to('/delete-coupon/'.$cou->id)}}" class="active styling-edit" ui-toggle-class=""><i class="fa fa-times text-danger text"></i></a>
            </td>
          </tr>  
          @endforeach     
        </tbody>
      </table>
    </div>
    <footer class="panel-footer">
      <div class="row">       
        <div class="col-sm-5 text-center">
          <small class="text-muted inline m-t-sm m-b-sm">showing 20-30 of 50 items</small>
        </div>
        <div class="col-sm-7 text-right text-center-xs">                
          <ul class="pagination pagination-sm m-t-none m-b-none">
            <li><a href=""><i class="fa fa-chevron-left"></i></a></li>
            <li><a href="">1</a></li>
            <li><a href="">2</a></li>
            <li><a href="">3</a></li>
            <li><a href="">4</a></li>
            <li><a href=""><i class="fa fa-chevron-right"></i></a></li>
          </ul>
        </div>
      </div>
    </footer>
  </div>
</div>
@endsection