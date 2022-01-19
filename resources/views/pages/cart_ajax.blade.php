@extends('layout')
@section('content')
<section id="cart_items">
			<div class="breadcrumbs">
				<ol class="breadcrumb">
				  <li><a href="{{URL::to('/')}}">Home</a></li>
				  <li class="active">Giỏ hàng của bạn</li>
				</ol>
			</div>
			<div class="table-responsive cart_info">
				<div class="card-body">
					@if (session('status'))
						<div class="alert alert-success" role="alert">
							{!! session('status') !!}
						</div>
					@elseif (session()->has('error'))
					<div class="alert alert-danger" role="alert">>
						{!! session()->get('error') !!}
					</div>
					@endif             
				</div>
				<table class="table table-condensed">
					<thead>
						<tr class="cart_menu">
							<td class="image">Hình ảnh</td>
							<td class="description">Tên sản phẩm</td>
							<td class="price">Giá</td>
							<td class="quantity">Số lượng</td>
							<td class="total">Thành tiền</td>
							<td></td>
						</tr>
					</thead>
					<tbody>	
					<form action="{{url('update-cart-ajax')}}" method="POST">
						@csrf
						@if(Session::get('cart') == true)
						@php
							$total = 0;
						@endphp

                        @foreach(Session::get('cart') as $key => $cart)
							@php 
								$subtotal = $cart['product_qty'] * $cart['product_price'];
								$total+=$subtotal;
							@endphp
						<tr>
							<td class="cart_product">
							    <a href="{{url('/chi-tiet-san-pham/'.$cart['id'])}}"><img src="{{asset('public/uploads/product/'.$cart['product_image'])}}" with="50"height="100"alt="{{$cart['product_name']}}"></a>
							</td>
							<td class="cart_description">
								<h4><a href=""></a></h4>
								<p>{{$cart['product_name']}}</p>
							</td>
							
							<td class="cart_price">
								<p>{{number_format($cart['product_price'],0,',','.')}}<sup>đ</sup></p>
							</td>
							<td class="cart_quantity">
								<div class="cart_quantity_button">
									<input class="cart_quantity" type="number" name="cart_qty[{{$cart['session_id']}}]" min="1" value="{{$cart['product_qty']}}" autocomplete="off" size="2">
								</div>
							</td>
							<td class="cart_total">
								<p class="cart_total_price">
									{{number_format($subtotal,0,',','.')}}
									<sup>đ</sup>
								</p>
							</td>
							<td class="cart_delete">
								<a class="cart_quantity_delete" href="{{url('/delete-product-ajax/'.$cart['session_id'])}}"><i class="fa fa-times"></i></a>
							</td>
						</tr>
						@endforeach
						<tr>
							<td>
								<input type="submit" value="Cập nhật giỏ hàng" name="update_qty" class="btn btn-primary btn-sm">
							</td>
							<td>
								<a href="{{URL::to('/del-all-product')}}" class="btn btn-default check_out">Xóa tất cả giỏ hàng</a>
							</td>
						</tr>
						<tr>
							<td>
							<div class="total_area">
								<ul>
									<li><h4>Thông tin đơn hàng</h4></li>
									<li>Tạm tính:&nbsp &nbsp{{number_format($total,0,',','.')}}<sup>đ</sup></li>
									@if(Session::get('coupon'))
									<li>
											@foreach(Session::get('coupon') as $key => $cou)
												@if($cou['coupon_condition'] == 1)
													Mã giảm giá:&nbsp &nbsp{{$cou['coupon_number']}} % 
													<p>
														@php 
														$total_coupon = ($total * $cou['coupon_number'])/100;
														echo '<p>Tổng giảm: &nbsp &nbsp '.number_format($total_coupon,0,',','.').'đ</p>'
														@endphp
													</p>
													<li>Tổng tiền:&nbsp &nbsp{{number_format($total - $total_coupon,0,',','.')}}<sup>đ</sup></li>
												@elseif ($cou['coupon_condition'] == 2)
													Số tiền giảm:&nbsp - {{number_format($cou['coupon_number'],0,',','.')}} đ
												<p>
													@php 
													$total_coupon = ($total - $cou['coupon_number']);
													@endphp
												</p>
												<li>Tổng tiền:&nbsp &nbsp{{number_format($total - $cou['coupon_number'],0,',','.')}}<sup>đ</sup></li>
												@endif
											@endforeach
									</li>
									@endif																			
									<!-- <li>Thuế: <span></span></li>
									<li>Phí vận chuyển: Free</li> -->
									
								</ul>
							</div>
							</td>
						</tr>
						</form>
						<tr>
							<td>	
							<style>
								.input-coupon{
									display: table-cell;
								}
								.delete_coupon{
									display: block;
									background-color: orange;
								}
							</style>			
							<form action="{{url('/check-coupon')}}" method="POST">
								@csrf
								<div class="input-group mb-3">
									<span class="input-coupon"><input type="text" class="form-control"name="coupon" placeholder="Nhập mã giảm giá" aria-label="Recipient's username" aria-describedby="basic-addon2"></span>
									<div class="input-group-append input-coupon">
										<input type="submit"class="btn btn-info check_coupon"name="check_coupon" value="Áp dụng">
									</div>
									@if(Session::get('coupon'))
									<a class="btn btn-default delete_coupon" href="{{url('/unset-coupon')}}">Xóa mã</a>
									@endif
								</div>
							</form>	
							<div class="card-body">
									@if (session('check_ok'))
										<div class="alert alert-success" role="alert">
											{{ session('check_ok') }}
										</div>
									@elseif (session()->has('check_error'))
									<div class="alert alert-danger" role="alert">>
										{!! session()->get('check_error') !!}
									</div>
									@endif             
								</div>
								@if(Session::get('id'))
								<a class="btn btn-primary" href="{{url('/checkout')}}">Xác nhận giỏ hàng</a>
								@else
									<a class="btn btn-primary" href="{{url('/login-checkout')}}">Xác nhận giỏ hàng</a>
								@endif
							</td>	
						</tr>
						@else					
						<tr>
							<td colspan ="5"style="text-align:center">
							<?php
								echo "<br><h4>Giỏ hàng của bạn trống, vui lòng thêm sản phẩm vào giỏ hàng</h4>";
							?>
							</td>
						</tr>
						@endif
					</tbody>
				</table>							
			</div>
	</section>
	
@endsection