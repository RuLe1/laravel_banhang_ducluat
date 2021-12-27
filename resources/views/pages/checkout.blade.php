@extends('layout')
@section('content')
<section id="cart_items">
			<div class="breadcrumbs">
				<ol class="breadcrumb">
				  <li><a href="{{URL::to('/')}}">Home</a></li>
				  <li class="active">Thanh toán giỏ hàng</li>
				</ol>
			</div>
			<div class="register-req">
				<p><b><i>Vui lòng điền đầy đủ thông tin nhận hàng thì bạn mới có thể đặt hàng được</i></b></p>
			</div>
			<div class="shopper-informations">
				<h4>Điền thông tin nhận hàng</h4>
				<div class="col-md-7">              			
						<div class="bill-to">
							<div class="form-one">
                            <form method="POST"autocomplete="off">
								@csrf	
								<input type="text"name="shipping_name"class="shipping_name" placeholder="Họ và tên"required>
								<input type="text"name="shipping_email"class="shipping_email" placeholder="Email"required>
								<input type="text"name="shipping_address"class="shipping_address" placeholder="Địa chỉ"required>
								<input type="text"name="shipping_phone"class="shipping_phone" placeholder="Số điện thoại"required>
								<p>Ghi chú đơn hàng</p>
								<textarea name="shipping_notes"class="shipping_notes" placeholder="Ghi chú đơn hàng của bạn" rows="10"required></textarea>

								@if(Session::get('fee'))
								<input type="hidden"name="order_fee"class="order_fee"value="{{Session::get('fee')}}">
								@else
								<input type="hidden"name="order_fee"class="order_fee"value="15000">
								@endif

								@if(Session::get('coupon'))
									@foreach(Session::get('coupon') as $key => $cou)
									<input type="hidden"name="order_coupon"class="order_coupon"value="{{$cou['coupon_code']}}">
									@endforeach
								@else
									<input type="hidden"name="order_coupon"class="order_coupon"value="Không có">
								@endif

								<div class="">
									<div class="form-group">
										<label for="exampleInputFile">Chọn hình thức thanh toán</label>
										<select name="payment_select"class="form-control input-sm m-bot15 payment_select"require>
											<option value="0">Qua chuyển khoản</option>
											<option value="1">Tiền mặt</option>
										</select>
									</div>
								</div>
								<input type="button" value="Đặt hàng" name="send_order" class="btn btn-primary btn-sm send_order">
                            </form>
							</div>
						</div>
				</div>
				<div class="col-sm-5">
					<form>
						@csrf
						<div class="form-group">
							<label for="exampleInputFile">Chọn thành phố</label>
							<select name="city"id="city"class="form-control input-sm m-bot15 choose city">
								<option value="">----Chọn tỉnh, thành phố-----</option>
								@foreach($city as $key => $ci)
									<option value="{{$ci->matp}}">{{$ci->name_city}}</option>
								@endforeach
							</select>
						</div>
						<div class="form-group">
							<label for="exampleInputFile">Chọn quận huyện</label>
							<select name="province"id="province"class="form-control input-sm m-bot15 choose province">
								<option value="">----Chọn quận huyện-----</option>
							</select>
						</div>
						<div class="form-group">
							<label for="exampleInputFile">Chọn xã phường</label>
							<select name="wards"id="wards"class="form-control input-sm m-bot15 wards">
								<option value="">----Chọn xã phường-----</option>
							</select>
						</div>
						<input type="button"value="Tính phí vận chuyển"name="calculate_order"class="btn btn-primary calculate_delivery">
					</form>
				</div>
					<div class="review-payment col-sm-12">
				    	<h2>Xem lại giỏ hàng</h2>
			    	</div>
					<div class="col-sm-12 clearfix">
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
										<img src="{{asset('public/uploads/product/'.$cart['product_image'])}}" with="50"height="100"alt="{{$cart['product_name']}}">
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
											<!-- Có cả 2 session phí vận chuyển và mã coupon  -->
											@if(Session::get('coupon') && Session::get('fee'))
											<li>
												@foreach(Session::get('coupon') as $key => $cou)
													@if($cou['coupon_condition'] == 1)
														Mã giảm giá:&nbsp &nbsp -{{$cou['coupon_number']}} % 
														<p>
															@php 
															$total_coupon = ($total * $cou['coupon_number'])/100;
															echo '<p>Tổng giảm: &nbsp &nbsp -'.number_format($total_coupon,0,',','.').'đ</p>'
															@endphp
														</p>
														@if(Session::get('fee'))
															<li>Phí vận chuyển: {{number_format(Session::get('fee'),0,',','.')}}<sup>đ</sup></li> 
														@endif
														<li>Tổng tiền:&nbsp &nbsp{{number_format($total - $total_coupon + Session::get('fee'),0,',','.')}}<sup>đ</sup></li>
													@elseif ($cou['coupon_condition'] == 2)
														Số tiền giảm:&nbsp - {{number_format($cou['coupon_number'],0,',','.')}} đ
													<p>
														@php 
														$total_coupon = ($total - $cou['coupon_number']);
														@endphp
													</p>
													@if(Session::get('fee'))
														<li>Phí vận chuyển: {{number_format(Session::get('fee'),0,',','.')}}<sup>đ</sup></li> 
													@endif
													<li>Tổng tiền:&nbsp &nbsp{{number_format($total - $cou['coupon_number'] + Session::get('fee'),0,',','.')}}<sup>đ</sup></li>
													@endif
												@endforeach
											</li>
											<!-- có phí vận chuyển nhưng ko có coupon   -->
											@elseif (!Session::get('coupon') && Session::get('fee'))
												@if(Session::get('fee'))
													<li>Phí vận chuyển: {{number_format(Session::get('fee'),0,',','.')}}<sup>đ</sup></li> 
												@endif
												<li>Tổng tiền:&nbsp &nbsp{{number_format($total + Session::get('fee'),0,',','.')}}<sup>đ</sup></li>
											<!-- có coupon nhưng ko có phí vận chuyển  -->
											@elseif (Session::get('coupon') && !Session::get('fee'))
											@foreach(Session::get('coupon') as $key => $cou)
													@if($cou['coupon_condition'] == 1)
														<li>Mã giảm giá:&nbsp &nbsp -{{$cou['coupon_number']}} %</li>
														<p>
															@php 
															$total_coupon = ($total * $cou['coupon_number'])/100;
															echo '<li>Tổng giảm: &nbsp &nbsp -'.number_format($total_coupon,0,',','.').'đ</li>'
															@endphp
														</p>
														@if(Session::get('fee'))
															<li>Phí vận chuyển: {{number_format(Session::get('fee'),0,',','.')}}<sup>đ</sup></li> 
														@endif
														<li>Tổng tiền:&nbsp &nbsp{{number_format($total - $total_coupon + Session::get('fee'),0,',','.')}}<sup>đ</sup></li>
													@elseif ($cou['coupon_condition'] == 2)
														<li>Số tiền giảm:&nbsp - {{number_format($cou['coupon_number'],0,',','.')}} đ</li>
													<p>
														@php 
														$total_coupon = ($total - $cou['coupon_number']);
														@endphp
													</p>
													@if(Session::get('fee'))
														<li>Phí vận chuyển: {{number_format(Session::get('fee'),0,',','.')}}<sup>đ</sup></li> 
													@endif
													<li>Tổng tiền:&nbsp &nbsp{{number_format($total - $cou['coupon_number'] + Session::get('fee'),0,',','.')}}<sup>đ</sup></li>
													@endif
												@endforeach
											@endif																			
											<!-- <li>Thuế: <span></span></li>-->
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
									<!-- <a class="btn btn-primary" href="{{url('/checkout')}}">Xác nhận giỏ hàng</a> -->
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
					</div>
                <br>
                </div>
            </div>
	</section>
@endsection