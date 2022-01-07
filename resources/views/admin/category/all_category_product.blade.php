@extends('admin_layout')
@section('content')
<div class="table-agile-info">
  <div class="panel panel-default">
    <div class="panel-heading">
        Liệt kê danh mục sản phẩm
    </div>
    <div class="row w3-res-tb">
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
            <th><b>Tên danh mục</b></th>
            <th><b>Thuộc danh mục</b></th>
            <th><b>Tình trạng</b></th>
            <th><b>Ngày tạo</b></th>
            <th style="width:30px;"></th>
          </tr>
        </thead>
        <tbody>
          @php  $i = 1 @endphp
          @foreach($list_category as $key => $cate)
          <tr>
            <td>{{$i++}}</td>
            <td>{{$cate->category_name}}</td>
            <td>
              @if($cate->category_parent == 0)
                <span style="color:red">Danh mục cha</span>
              @else  
                @foreach($category as $key => $cate_sub)
                  @if($cate_sub->id == $cate->category_parent)
                    <span style="color:blue">{{$cate_sub->category_name}}</span>
                  @endif
                @endforeach
              @endif
            </td>
            <td>
              @if($cate->status == 0)
                <a href="{{URL::to('/unactive-category-product/'.$cate->id)}}"><span class="text-ellipsis text-danger">Ẩn</span></a>
              @else
              <a href="{{URL::to('/active-category-product/'.$cate->id)}}"><span class="text-ellipsis text-success">Hiển thị</span></a>
              @endif
            </td>
            <td><span class="text-ellipsis">12/5/2019</span></td>
            <td>
              <a href="{{URL::to('/edit-category-product/'.$cate->id)}}" class="active styling-edit" ui-toggle-class=""><i class="fa fa-pencil-square-o text-success text-active"></i></a>
              <a onclick="return confirm('Bạn chắc chắn muốn xóa danh mục {{$cate->category_name}} không?')"href="{{URL::to('/delete-category-product/'.$cate->id)}}" class="active styling-edit" ui-toggle-class=""><i class="fa fa-times text-danger text"></i></a>
            </td>
          </tr>  
          @endforeach
        </tbody>
      </table>
    </div>
    <footer class="panel-footer">
      <div class="row">       
        <div class="col-sm-5 text-center">
          <small class="text-muted inline m-t-sm m-b-sm">showing 20-30 of 50 items</small>
        </div>
        <div class="col-sm-7 text-right text-center-xs">                
          <ul class="pagination pagination-sm m-t-none m-b-none">
            {!!$list_category->links('pagination::bootstrap-4')!!}
          </ul>
        </div>
      </div>
    </footer>
  </div>
</div>
@endsection