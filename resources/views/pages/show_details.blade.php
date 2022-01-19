@extends('layout')
@section('content')
@foreach($details_product as $key => $value)
<div class="product-details">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{'/'}}">Trang chủ</a></li>
            <li class="breadcrumb-item"><a href="{{url('/danh-muc-san-pham/'.$category_id)}}">{{$value->categoryproduct->category_name}}</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{$value->product_name}}</li>
        </ol>
    </nav>
    <div class="col-sm-5">
        <ul id="imageGallery">
            @foreach($gallery as $key=>$gal)
            <li data-thumb="{{asset('public/uploads/gallery/'.$gal->gallery_image)}}" data-src="{{asset('public/uploads/gallery/'.$gal->gallery_image)}}">
                <img width="100%" alt="{{$gal->gallery_name}}"src="{{asset('public/uploads/gallery/'.$gal->gallery_image)}}" />
            </li>
            @endforeach
            <!-- <li data-thumb="{{asset('frontend/images/product3.jpg')}}" data-src="{{asset('frontend/images/product3.jpg')}}">
                <img width="100%" src="{{asset('frontend/images/product3.jpg')}}" />
            </li>
            <li data-thumb="{{asset('frontend/images/product5.jpg')}}" data-src="{{asset('frontend/images/product5.jpg')}}">
                <img width="100%" src="{{asset('frontend/images/product5.jpg')}}" />
            </li> -->
        </ul>
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
                @if(($value->product_quantity) == 0)

                <input  type="number"disabled name="qty" class="cart_product_qty_{{$value->id}}" min="1"value="1" />

				<input type="hidden" value="{{$value->id}}" class="cart_product_id_{{$value->id}}">
                <input type="hidden" value="{{$value->product_name}}" class="cart_product_name_{{$value->id}}">
                <input type="hidden" value="{{$value->product_image}}" class="cart_product_image_{{$value->id}}">
                <input type="hidden" value="{{$value->product_price}}" class="cart_product_price_{{$value->id}}">
                <input disabled type="hidden" value="{{$value->product_quantity}}" class="cart_product_quantity_{{$value->id}}">
                <input name="productid_hidden" type="hidden"value="{{$value->id}}"/>
                
                <button type="button"disabled class="btn btn-fefault add-to-cart"data-id_product="{{$value->id}}" name="add-to-cart">
                    <i class="fa fa-shopping-cart"></i>
                   Thêm giỏ hàng
                </button>
                @else
                <input type="number" name="qty" class="cart_product_qty_{{$value->id}}" min="1"value="1" />

				<input type="hidden" value="{{$value->id}}" class="cart_product_id_{{$value->id}}">
                <input type="hidden" value="{{$value->product_name}}" class="cart_product_name_{{$value->id}}">
                <input type="hidden" value="{{$value->product_image}}" class="cart_product_image_{{$value->id}}">
                <input type="hidden" value="{{$value->product_price}}" class="cart_product_price_{{$value->id}}">
                <input type="hidden" value="{{$value->product_quantity}}" class="cart_product_quantity_{{$value->id}}">
                <input name="productid_hidden" type="hidden"value="{{$value->id}}"/>
                
                <button type="button" class="btn btn-fefault add-to-cart"data-id_product="{{$value->id}}" name="add-to-cart">
                    <i class="fa fa-shopping-cart"></i>
                   Thêm giỏ hàng
                </button>
                @endif
            </span>
            </form>
            <p>Số lượng kho còn: <b style="font-size: medium;">{{$value->product_quantity}}</b> sản phẩm có sẵn</p>
            <p><b>Điều kiện:</b> Mới 100%</p>
            <p><b>Thương hiệu:</b> {{$value->brandproduct->brand_name}}</p>
            <p><b>Danh mục:</b> {{$value->categoryproduct->category_name}}</p>
            <a href=""><img src="images/product-details/share.png" class="share img-responsive"  alt="" /></a>
        </div>
        <div class="product-tags">
            <style type="text/css">
                a.tags_style{
                    margin: 3px 2px;
                    border: 1px solid;

                    height: auto;
                    background: #428bca;
                    color: #ffff;
                    padding: 0px;
                }
                a.tags_style:hover{
                    background: black;
                }
            </style>
            <fieldset>
                <legend>Tags</legend>
                <p><i class="fa fa-tag"></i>
                    @php  
                        $tags = $value->product_tags;
                        $tags = explode(",",$tags);
                    @endphp
                    <!-- //dùng hàm Str::slug() của Laravel-->
                    @foreach($tags as $tag)
                        <a href="{{url('/tag/'.Str::slug($tag))}}"class="tags_style">{{$tag}}</a>
                    @endforeach
                </p>
            </fieldset>
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