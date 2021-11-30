@extends('layout')
@section('content')
<section id="cart_items">
    <div class="breadcrumbs">
        <ol class="breadcrumb">
            <li><a href="{{URL::to('/')}}">Home</a></li>
            <li class="active">Thanh toán giỏ hàng</li>
        </ol>
    </div>
    <div class="shopper-informations">
        <div class="row">              			
            <div class="review-payment col-sm-12">
                <h2>Xem lại giỏ hàng</h2>
            </div>
            <?php
				$content = Cart::content();
				// echo '<pre>';
				// print_r($content);
				// echo '<pre>';
			?>
			<div class="table-responsive cart_info">
				<table class="table table-condensed">
					<thead>
						<tr class="cart_menu">
							<td class="image">Hình ảnh</td>
							<td class="description">Tên sản phẩm</td>
							<td class="price">Giá</td>
							<td class="quantity">Số lượng</td>
							<td class="total">Tổng tiền</td>
							<td></td>
						</tr>
					</thead>
					<tbody>
						@foreach($content as $key =>$v_content)
						<tr>
							<td class="cart_product">
								<a href=""><img src="{{URL::to('public/uploads/product/'.$v_content->options->image)}}" with="50"height="100"alt=""></a>
							</td>
							<td class="cart_description">
								<h4><a href="">{{$v_content->name}}</a></h4>
								<p>Web ID: 1089772</p>
							</td>
							<td class="cart_price">
								<p>{{number_format($v_content->price)}}<sup>đ</sup></p>
							</td>
							<td class="cart_quantity">
								<div class="cart_quantity_button">
									<form action="{{URL::to('/update-cart-quantity')}}" method="POST">
										@csrf
										<input class="cart_quantity_input" type="text" name="cart_quantity" value="{{$v_content->qty}}"min="1" autocomplete="off" size="2">
										<input type="hidden" value="{{$v_content->rowId}}" name="rowId_cart" class="form-control">
										<input type="submit" value="Cập nhật" name="update_qty" class="btn btn-default btn-sm">
									</form>
								</div>
							</td>
							<td class="cart_total">
								<p class="cart_total_price">
									<?php
										$subtotal = $v_content->price * $v_content->qty;
										echo number_format($subtotal);
									?>
									<sup>đ</sup>
								</p>
							</td>
							<td class="cart_delete">
								<a class="cart_quantity_delete" href="{{URL::to('/delete-to-cart/'.$v_content->rowId)}}"><i class="fa fa-times"></i></a>
							</td>
						</tr>
						@endforeach
					</tbody>
				</table>
			</div>
            <br>
			<h4 style="margin: 40px 0;">Chọn hình thức thanh toán</h4>
			<form action="{{URL::to('/order-place')}}"method="POST">
				@csrf
            <div class="payment-options">
                <span>
                    <label><input name="payment_option" value="1" type="checkbox"> Thanh toán bằng thẻ ATM</label>
                </span>
                <span>
                    <label><input name="payment_option" value="2" type="checkbox"> Thanh toán sau khi nhận hàng</label>
                </span>
                <span>
                    <label><input name="payment_option" value="3" type="checkbox"> Paypal</label>
                </span>
				<input type="submit" value="Đặt hàng" name="send_order" class="btn btn-primary btn-sm">
            </div>
			</form>
        </div>
    </div>
</section>
@endsection