@extends('layout')
@section('content')
<section id="form">
		<div class="container">
			<div class="row">
				<div class="col-sm-3 col-sm-offset-1">
					<div class="login-form"><!--login form-->
						<h2>Đăng nhập tài khoản</h2>
						<form action="{{URL::to('/login-customer')}}" method="POST">
							@csrf 
							<input type="email"name="email_account" placeholder="Tên tài khoản" />
							<input type="password"name="password_account"placeholder="Mật khẩu" />
							<span>
								<input type="checkbox" class="checkbox"> 
								Ghi nhớ đăng nhập
							</span>
							<button type="submit" class="btn btn-default">Đăng nhập</button>
						</form>
					</div>
				</div>
				<div class="col-sm-1">
					<h2 class="or">hoặc</h2>
				</div>
				<div class="col-sm-4">
					<div class="signup-form"><!--sign up form-->
						<h2>Đăng kí tài khoản mới</h2>
						@if ($errors->any())
						<div class="alert alert-danger">
							<ul>
								@foreach ($errors->all() as $error)
									<li>{{ $error }}</li>
								@endforeach
							</ul>
						</div>
                		@endif
						<form action="{{URL::to('/add-customer')}}" method="POST">
                            @csrf
							<input type="text"name="customer_name" placeholder="Họ và tên" required/>
							<input type="email"name="customer_email"placeholder="Địa chỉ Email" required/>
							<input type="password"name="customer_password" placeholder="Mật khẩu" required/>
							<input type="text"name="customer_phone" placeholder="Số điện thoại" required/>
							
							<div class="g-recaptcha" data-sitekey="{{env('CAPTCHA_KEY')}}"></div>
							<br/>
							@if($errors->has('g-recaptcha-response'))
							<div class="alert alert-danger">
								<strong>{{$errors->first('g-recaptcha-response')}}</strong>
							</div>
							@endif
							<button type="submit" class="btn btn-default">Đăng kí</button>
						</form>
					</div>
				</div>
			</div>
		</div>
	</section>
@endsection