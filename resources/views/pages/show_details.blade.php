@extends('layout')
@section('content')
@foreach($details_product as $key => $value)
<div class="product-details">
    <div class="col-sm-5">
        <div class="view-product">
            <img src="{{URL::to('/public/uploads/product/'.$value->product_image)}}" alt="" />
            <h3>ZOOM</h3>
        </div>
        <div id="similar-product" class="carousel slide" data-ride="carousel">           
                <!-- Wrapper for slides -->
                <div class="carousel-inner">
                    <div class="item active">
                        <a href=""><img src="{{URL::to('/frontend/images/similar1.jpg')}}" alt=""></a>
                        <a href=""><img src="{{URL::to('/frontend/images/similar2.jpg')}}" alt=""></a>
                        <a href=""><img src="{{URL::to('/frontend/images/similar3.jpg')}}" alt=""></a>
                    </div>
                    <div class="item">
                        <a href=""><img src="{{URL::to('/frontend/images/similar1.jpg')}}" alt=""></a>
                        <a href=""><img src="{{URL::to('/frontend/images/similar2.jpg')}}" alt=""></a>
                        <a href=""><img src="{{URL::to('/frontend/images/similar3.jpg')}}" alt=""></a>
                    </div>
                    <div class="item">
                        <a href=""><img src="{{URL::to('/frontend/images/similar1.jpg')}}" alt=""></a>
                        <a href=""><img src="{{URL::to('/frontend/images/similar2.jpg')}}" alt=""></a>
                        <a href=""><img src="{{URL::to('/frontend/images/similar3.jpg')}}" alt=""></a>
                    </div>                  
                </div>
                <!-- Controls -->
                <a class="left item-control" href="#similar-product" data-slide="prev">
                <i class="fa fa-angle-left"></i>
                </a>
                <a class="right item-control" href="#similar-product" data-slide="next">
                <i class="fa fa-angle-right"></i>
                </a>
        </div>
    </div>
    <div class="col-sm-7">
        <div class="product-information">
            <img src="images/product-details/new.jpg" class="newarrival" alt="" />
            <h2>{{$value->product_name}}</h2>
            <p>Mã ID: {{$value->id}}</p>
            <img src="images/product-details/rating.png" alt="" />
            <form>
                @csrf
            <span>
                <h3><span>{{number_format($value->product_price)}}<sup>đ</sup></span></h3>
                <label>Số lượng:</label>
                <input type="number" name="qty" class="cart_product_qty_{{$value->id}}" min="1"value="1" />

				<input type="hidden" value="{{$value->id}}" class="cart_product_id_{{$value->id}}">
                <input type="hidden" value="{{$value->product_name}}" class="cart_product_name_{{$value->id}}">
                <input type="hidden" value="{{$value->product_image}}" class="cart_product_image_{{$value->id}}">
                <input type="hidden" value="{{$value->product_price}}" class="cart_product_price_{{$value->id}}">

                <input name="productid_hidden" type="hidden"value="{{$value->id}}"/>
                <button type="button" class="btn btn-fefault add-to-cart"data-id_product="{{$value->id}}" name="add-to-cart">
                    <i class="fa fa-shopping-cart"></i>
                   Thêm giỏ hàng
                </button>
            </span>
            </form>
            <p><b>Tình trạng:</b> Còn hàng</p>
            <p><b>Điều kiện:</b> Mới 100%</p>
            <p><b>Thương hiệu:</b> {{$value->brandproduct->brand_name}}</p>
            <p><b>Danh mục:</b> {{$value->categoryproduct->category_name}}</p>
            <a href=""><img src="images/product-details/share.png" class="share img-responsive"  alt="" /></a>
        </div>
    </div>
</div>
<div class="category-tab shop-details-tab"><!--category-tab-->
    <div class="col-sm-12">
        <ul class="nav nav-tabs">
            <li class="active"><a href="#details" data-toggle="tab">Details</a></li>
            <li><a href="#companyprofile" data-toggle="tab">Company Profile</a></li>
            <li><a href="#tag" data-toggle="tab">Tag</a></li>
            <li><a href="#reviews" data-toggle="tab">Reviews (5)</a></li>
        </ul>
    </div>
    <div class="tab-content">
        <div class="tab-pane fade active in" id="details">
        <div class="col-sm-12">
            {!!$value->product_desc!!}
        </div>
        </div>
        <div class="tab-pane fade" id="companyprofile" >
            <div class="col-sm-3">
                <div class="product-image-wrapper">
                    <div class="single-products">
                        <div class="productinfo text-center">
                            <img src="images/home/gallery1.jpg" alt="" />
                            <h2>$56</h2>
                            <p>Easy Polo Black Edition</p>
                            <button type="button" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Add to cart</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>							
    <div class="tab-pane fade" id="tag" >
        <div class="col-sm-3">
            <div class="product-image-wrapper">
                <div class="single-products">
                    <div class="productinfo text-center">
                        <img src="images/home/gallery1.jpg" alt="" />
                        <h2>$56</h2>
                        <p>Easy Polo Black Edition</p>
                        <button type="button" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Add to cart</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="tab-pane fade" id="reviews" >
        <div class="col-sm-12">
            <ul>
                <li><a href=""><i class="fa fa-user"></i>EUGEN</a></li>
                <li><a href=""><i class="fa fa-clock-o"></i>12:41 PM</a></li>
                <li><a href=""><i class="fa fa-calendar-o"></i>31 DEC 2014</a></li>
            </ul>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.</p>
            <p><b>Write Your Review</b></p>
            
            <form action="#">
                <span>
                    <input type="text" placeholder="Your Name"/>
                    <input type="email" placeholder="Email Address"/>
                </span>
                <textarea name=""></textarea>
                <b>Rating: </b> <img src="images/product-details/rating.png" alt="" />
                <button type="button" class="btn btn-default pull-right">
                    Submit
                </button>
            </form>
        </div>
    </div>							
</div>
</div>
@endforeach					
    <div class="recommended_items">
        <h2 class="title text-center">Sản phẩm liên quan</h2>       
        <div id="recommended-item-carousel" class="carousel slide" data-ride="carousel">
            <div class="carousel-inner">
                <div class="item active">
                    @foreach($related_product as $key => $lienquan)	
                    <div class="col-sm-4">
                        <div class="product-image-wrapper">
                            <div class="single-products">
                                <div class="productinfo text-center">
                                    <img src="{{URL::to('/public/uploads/product/'.$lienquan->product_image)}}"width="200"height="200" alt=""/>
                                    <h2>{{number_format($lienquan->product_price)}}</h2>
                                    <p>{{$lienquan->product_name}}</p>
                                    <button type="button" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Thêm giỏ hàng</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
                <a class="left recommended-item-control" href="#recommended-item-carousel" data-slide="prev">
                    <i class="fa fa-angle-left"></i>
                </a>
                <a class="right recommended-item-control" href="#recommended-item-carousel" data-slide="next">
                    <i class="fa fa-angle-right"></i>
                </a>			
        </div>
    </div>
@endsection