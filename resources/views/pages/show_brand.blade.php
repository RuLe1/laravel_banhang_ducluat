@extends('layout')
@section('content')
<div class="features_items"><!--features_items-->
@foreach($brand_name as $key =>$brand)
<h2 class="title text-center">{{$brand->brand_name}}</h2>
@endforeach
        @foreach($product_from_brand as $key =>$pro)
		<div class="col-sm-4">
			<div class="product-image-wrapper">
				<div class="single-products">
					<form>
                		@csrf
						<div class="productinfo text-center">
							<img src="{{URL::to('public/uploads/product/'.$pro->product_image)}}" with="233"height="255"alt="" />
							<h2>{{number_format($pro->product_price).' '.'VND'}}</h2>
							<p>{{$pro->product_name}}</p>
							<a href="#" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Thêm giỏ hàng</a>
						</div>
						<div class="product-overlay">
							<div class="overlay-content">
                                <a href="{{URL::to('/chi-tiet-san-pham/'.$pro->id)}}"><h2>Xem chi tiết</h2></a>
								<p>{{$pro->product_name}}</p>
								<!-- <input name="qty" type="hidden" min="1"value="1" />
                				<input name="productid_hidden" type="hidden"value="{{$pro->id}}"/> -->
								<input type="hidden"class="cart_product_id_{{$pro->id}}"value="{{$pro->id}}">
								<input type="hidden"class="cart_product_name_{{$pro->id}}"value="{{$pro->product_name}}">
								<input type="hidden"class="cart_product_image_{{$pro->id}}"value="{{$pro->product_image}}">
								<input type="hidden"class="cart_product_price_{{$pro->id}}"value="{{$pro->product_price}}">
								<input type="hidden"class="cart_product_qty_{{$pro->id}}"value="1">
								<button type="button"name="add_to_cart"data-id_product="{{$pro->id}}" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Thêm giỏ hàng</a>
							</div>
						</div>
					</form>
				</div>
				<div class="choose">
					<ul class="nav nav-pills nav-justified">
						<li><a href="#"><i class="fa fa-plus-square"></i>Yêu thích</a></li>
						<li><a href="#"><i class="fa fa-plus-square"></i>So sánh</a></li>
					</ul>
				</div>
			</div>
		</div>
		@endforeach
@endsection