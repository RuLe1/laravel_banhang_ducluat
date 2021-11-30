<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <title>Document</title>
</head>
<body>				
    <div class="col-md-6" style="padding-top:0px">		 
        <div class="" style="color:#0f146d;text-align:center">Cám ơn bạn đã đặt hàng tại E-Closet</div>
        <div class="">
            <h2>Xin chào{{$shipping_array['customer_name']}}</h2>
            <p>Lazada đã nhận được yêu cầu đặt hàng của bạn và đang xử lý nhé. Bạn sẽ nhận được thông báo tiếp theo khi đơn hàng đã sẵn sàng được giao.</p>
           
        </div>
    </div>
    <div class="col-md-12">
	    <div class="">Đơn hàng được giao đến:</div>
            <div class="">
            <table cellpadding="2" cellspacing="0" width="100%">
                <tbody>
                <tr>
                    <td width="25%" valign="top" style="color:#0f146d;font-weight:bold">Họ và tên:</td>
                    @if($shipping_array['shipping_name'] == '') Không có
                    @else
                    <td width="75%" valign="top">{{$shipping_array['shipping_name']}}</td>
                    @endif
                </tr>
                <tr>
                    <td valign="top" style="color:#0f146d;font-weight:bold">Địa chỉ nhà:</td>
                    @if($shipping_array['shipping_address'] == '') Không có
                    @else
                    <td valign="top">{{$shipping_array['shipping_address']}}</td>
                    @endif
                </tr>
                <tr>
                    <td valign="top" style="color:#0f146d;font-weight:bold">Số điện thoại:</td>
                    @if($shipping_array['shipping_phone'] == '') Không có
                    @else
                    <td valign="top">{{$shipping_array['shipping_phone']}}</td>
                    @endif
                </tr>
                <tr>
                    <td valign="top" style="color:#0f146d;font-weight:bold">Email:</td>
                    @if($shipping_array['shipping_email'] == '') Không có
                    @else
                    <td valign="top"><a href="mailto:{{$shipping_array['shipping_email']}}" target="_blank">{{$shipping_array['shipping_email']}}</a></td>
                    @endif
                </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="" style="padding-top:0px">
    <div class="">
        <table cellpadding="0" cellspacing="0" class="" style="border-bottom:1px solid #d8d8d8">
            <thead>
                <tr>
                    <th>Tên sản phẩm</th>
                    <th>Giá tiền</th>
                    <th>Số lượng</th>
                    <th>Thành tiền</th>
                </tr>
            </thead>
            <tbody>
                @php   
                    $sub_total = 0;
                    $total = 0;
                @endphp
                @foreach($cart_array as $key => $cart)
                    @php  
                        $sub_total = $cart['product_price'] * $cart['product_qty'];
                        $total+=$sub_total;
                    @endphp
                <tr>
                    <td>{{$cart['product_name']}}</td>
                    <td>{{$cart['product_price']}}</td>
                    <td>{{$cart['product_qty']}}</td>
                    <td>{{$number_format($sub_total,0,',','.')}} VNĐ</td>
                </tr>   
                @endforeach 
                <tr>
                    <td>Tổng tiền thanh toán: {{number_format($total,0,',','.')}} VNĐ</td>
                </tr>                         
            </tbody>
        </table>
        <br>
        <table cellpadding="0" cellspacing="0" class="m_-493294633880776504checkout-amount">
            <tbody>
            <tr>
                <td valign="top" style="color:#585858;width:49%">Hình thức thanh toán:</td>
                <td align="right" valign="top" colspan="2">
                    @if(shipping_array['shipping_method'] == 0)
                    Chuyển khoản ATM 
                    @else Tiền mặt 
                    @endif  
                </td>
            </tr>
            </tbody>
        </table>
    </div>
    </div>
</div>

</body>
</html>

