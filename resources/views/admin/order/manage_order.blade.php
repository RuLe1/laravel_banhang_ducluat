@extends('admin_layout')
@section('content')
<div class="table-agile-info">
  <div class="panel panel-default">
    <div class="panel-heading">
        Liệt kê đơn hàng
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
            <th><b>Thứ tự</b></th>
            <th><b>Mã đơn hàng</b></th>
            <th><b>Ngày đặt hàng</b></th>
            <th><b>Tình trạng đơn hàng</b></th>
            
            <th style="width:30px;"></th>
          </tr>
        </thead>
        <tbody>
          @php 
            $i=0;
          @endphp
          @foreach($order as $key => $ord)
          @php 
            $i++;
          @endphp
          <tr>
            <td>{{$i}}</td>
            <td>{{$ord->order_code}}</td>
            <td>{{$ord->created_at}}</td>
            <td>
              @if($ord->order_status == 1)
                Đơn hàng mới
              @elseif($ord->order_status == 2)
                <span class="text-success">Đã giao hàng</span>
              @else  
              <span class="text-danger">Đã hủy</span>
              @endif
            </td>
            <td>
              <a href="{{URL::to('/view-order/'.$ord->order_code)}}" class="active styling-edit" ui-toggle-class=""><i class="fa fa-eye text-primary text-active"></i></a>
              <a onclick="return confirm('Bạn chắc chắn muốn xóa thương hiệu {{$ord->order_code}} không?')"href="{{URL::to('/delete-order/'.$ord->order_code)}}" class="active styling-edit" ui-toggle-class=""><i class="fa fa-times text-danger text"></i></a>
            </td>
          </tr>  
          @endforeach     
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection