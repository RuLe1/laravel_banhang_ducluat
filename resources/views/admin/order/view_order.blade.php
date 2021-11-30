@extends('admin_layout')
@section('content')
<div class="table-agile-info">  
  <div class="panel panel-default">
    <div class="panel-heading">
      Thông tin khách hàng đăng nhập
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
            <th><b>Tên khách hàng</b></th>
            <th><b>Số điện thoại</b></th>
            <th><b>Email</b></th>
            <th style="width:30px;"></th>
          </tr>
        </thead>
        <tbody>        
          <tr>
            <td><label class="i-checks m-b-none"><input type="checkbox" name="post[]"><i></i></label></td>
            <td>{{$customer->customer_name}}</td>
            <td>{{$customer->customer_phone}}</td>
            <td>{{$customer->customer_email}}</td>
          </tr>            
        </tbody>
      </table>
    </div>
  </div>
</div>
<br>
<div class="table-agile-info">
  <div class="panel panel-default">
    <div class="panel-heading">
      Thông tin vận chuyển
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
            <th><b>Tên người nhận hàng</b></th>
            <th><b>Địa chỉ</b></th>
            <th><b>Số điện thoại</b></th>
            <th><b>Email</b></th>
            <th><b>Ghi chú</b></th>
            <th><b>Hình thức thanh toán</b></th>

            <th style="width:30px;"></th>
          </tr>
        </thead>
        <tbody>        
          <tr>
            <td><label class="i-checks m-b-none"><input type="checkbox" name="post[]"><i></i></label></td>
            <td>{{$shipping->shipping_name}}</td>
            <td>{{$shipping->shipping_address}}</td>
            <td>{{$shipping->shipping_phone}}</td>
            <td>{{$shipping->shipping_email}}</td>
            <td>{{$shipping->shipping_notes}}</td>
            <td>
              @if($shipping->shipping_method == 0)  
              Chuyển khoản
              @else 
              Tiền mặt
              @endif
            </td>
          </tr>            
        </tbody>
      </table>
    </div>
  </div>
</div>
<br><br>
<div class="table-agile-info">
  <div class="panel panel-default">
    <div class="panel-heading">
        Liệt kê chi tiết đơn hàng
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
            <th>Thứ tự</th>
            <th><b>Tên sản phẩm</b></th>
            <th><b>Mã giảm giá</b></th>
            <th><b>Phí ship</b></th>
            <th><b>Số lượng</b></th>
            <th><b>Giá</b></th>
            <th><b>Thành tiền</b></th>
            <th style="width:30px;"></th>
          </tr>
        </thead>
        <tbody>  
          @php 
            $i = 0;
            $total = 0;
          @endphp
          @foreach($order_details_product as $key =>$detail)  
            @php 
            $i++;
            $subtotal = $detail->product_sales_quantity * $detail->product_price;  
            $total+=$subtotal;
            @endphp
          <tr>
            <td>{{$i}}</td>
            <td>{{$detail->product->product_name}}</td>
            <td>
              @if($detail->product_coupon !='Không có')
                {{$detail->product_coupon}}
              @else Không mã
              @endif
            </td>
            <td>{{number_format($detail->product_feeship,0,',','.')}}</td>
            <td>{{$detail->product_sales_quantity}}</td>
            <td>{{number_format($detail->product_price,0,',','.')}}</td>
            <td>{{number_format($subtotal,0,',','.')}} đ</td>
          </tr>
          @endforeach 
          <tr>
          <td>
              @php 
                $total_coupon = 0;
              @endphp
              @if($coupon_condition == 1)
                @php
                  $total_after_coupon = ($total * $coupon_number)/100;
                  echo 'Tiền mã giảm giá: -'.number_format($total_after_coupon,0,',','.').'</br>';
                  $total_coupon = $total -  $total_after_coupon;
                @endphp
              @else 
                @php
                  echo 'Tiền mã giảm giá: -'.number_format($coupon_number,0,',','.').'</br>';
                  $total_coupon = $total - $coupon_number;
                @endphp
              @endif
              Phí vận chuyển: {{number_format($detail->product_feeship,0,',','.')}}</br>
              <b>Tổng thanh toán:  {{number_format($total_coupon + $detail->product_feeship,0,',','.')}}đ</b>
            </td>
          </tr>   
        </tbody>
      </table>
      <a target="_blank" href="{{('/print-order/'.$detail->order_code)}}"><i class="fa fa-print"></i>In đơn hàng</a>
    </div>
  </div>
</div>
   
@endsection