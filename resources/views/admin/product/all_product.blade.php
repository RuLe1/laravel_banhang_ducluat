@extends('admin_layout')
@section('content')
<div class="table-agile-info">
  <div class="panel panel-default">
    <div class="panel-heading">
        Liệt kê sản phẩm
    </div>
    <!-- <div class="row w3-res-tb">
      <div class="col-sm-5 m-b-xs">
        <select class="input-sm form-control w-sm inline v-middle">
          <option value="0">Bulk action</option>
          <option value="1">Delete selected</option>
          <option value="2">Bulk edit</option>
          <option value="3">Export</option>
        </select>
        <button class="btn btn-sm btn-default">Apply</button>                
      </div>
      <div class="col-sm-4">
      </div>
      <div class="col-sm-3">
        <div class="input-group">
          <input type="text" class="input-sm form-control" placeholder="Search">
          <span class="input-group-btn">
            <button class="btn btn-sm btn-default" type="button">Go!</button>
          </span>
        </div>
      </div>
    </div> -->
    <div class="card-body">
          @if (session('status'))
              <div class="alert alert-success" role="alert">
                  {{ session('status') }}
              </div>
          @endif             
      </div>
    <div class="table-responsive">
      <table class="table table-striped b-t b-light" id="myTable">
        <thead>
          <tr>
            <th style="width:20px;">
              <label class="i-checks m-b-none">
                <input type="checkbox"><i></i>
              </label>
            </th>
            <th><b>Tên sản phẩm</b></th>
            <th><b>Thư viện ảnh</b></th>
            <th><b>Số lượng</b></th>
            <th><b>Giá</b></th>
            <th><b>Hình ảnh</b></th>
            <th><b>Danh mục</b></th>
            <th><b>Thương hiệu</b></th>
            <th><b>Tình trạng</b></th>
            <th><b>Ngày tạo</b></th>
            <th style="width:30px;"></th>
          </tr>
        </thead>
        <tbody>
          @foreach($list_product as $key => $pro)
          <tr>
            <td><label class="i-checks m-b-none"><input type="checkbox" name="post[]"><i></i></label></td>
            <td>{{$pro->product_name}}</td>
            <td><a href="{{url('/add-gallery/'.$pro->id)}}">Thêm thư viện</a></td>
            <td>{{$pro->product_quantity}}</td>
            <td>{{$pro->product_price}}</td>
            <td><img src="public/uploads/product/{{$pro->product_image}}"width="150" height="150"></td>
            <td>{{$pro->categoryproduct->category_name}}</td>
            <td>{{$pro->brandproduct->brand_name}}</td>
            <td>       
              @if($pro->status == 0)
                <a href="{{URL::to('/unactive-product/'.$pro->id)}}"><span class="text-ellipsis text-danger">Ẩn</span></a>
              @else
              <a href="{{URL::to('/active-product/'.$pro->id)}}"><span class="text-ellipsis text-success">Hiển thị</span></a>
              @endif
            </td>
            <td><span class="text-ellipsis">12/5/2019</span></td>
            <td>
              <a href="{{URL::to('/edit-product/'.$pro->id)}}" class="active styling-edit" ui-toggle-class=""><i class="fa fa-pencil-square-o text-success text-active"></i></a>
              <a onclick="return confirm('Bạn chắc chắn muốn xóa sản phẩm {{$pro->product_name}} không?')"href="{{URL::to('/delete-product/'.$pro->id)}}" class="active styling-edit" ui-toggle-class=""><i class="fa fa-times text-danger text"></i></a>
            </td>
          </tr>  
          @endforeach     
        </tbody>
      </table>
    </div>
    <!---- Import,export data bằng file Exel --->
    <form action="{{url('/import-csv-product')}}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="file" name="file" accept=".xlsx"><br>
        <input type="submit" value="Import Excel" name="import_csv" class="btn btn-warning">
    </form>
    <form action="{{url('/export-csv-product')}}" method="POST">
        @csrf
        <input type="submit" value="Export Excel" name="export_csv" class="btn btn-success">
    </form>
    <!-- <footer class="panel-footer">
      <div class="row">       
        <div class="col-sm-5 text-center">
          <small class="text-muted inline m-t-sm m-b-sm">showing 20-30 of 50 items</small>
        </div>
        <div class="col-sm-7 text-right text-center-xs">                
          <ul class="pagination pagination-sm m-t-none m-b-none">
            <li><a href=""><i class="fa fa-chevron-left"></i></a></li>
            <li><a href="">1</a></li>
            <li><a href="">2</a></li>
            <li><a href="">3</a></li>
            <li><a href="">4</a></li>
            <li><a href=""><i class="fa fa-chevron-right"></i></a></li>
          </ul>
        </div>
      </div>
    </footer> -->
  </div>
</div>
@endsection