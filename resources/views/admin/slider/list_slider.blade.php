@extends('admin_layout')
@section('content')
<div class="table-agile-info">
  <div class="panel panel-default">
    <div class="panel-heading">
        Liệt kê ảnh slider
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
            <th><b>Thứ tự</b></th>
            <th><b>Tên Slide</b></th>
            <th><b>Hình ảnh</b></th>
            <th><b>Mô tả</b></th>
            <th><b>Tình trạng</b></th>

            <th style="width:30px;"></th>
          </tr>
        </thead>
        <tbody>
            @php  
                $i=0;
            @endphp
          @foreach($all_slide as $key => $slide)
          @php
          $i++;
          @endphp
          <tr>
            <td>{{$i}}</td>
            <td>{{$slide->slider_name}}</td>
            <td><img src="public/uploads/slider/{{$slide->slider_image}}"width="250px"height="250px"></td>
            <td>{{$slide->slider_desc}}</td>
            <td>          
              @if($slide->status == 0)
                <a href="{{URL::to('/unactive-slider/'.$slide->id)}}"><span class="text-ellipsis text-danger">Ẩn</span></a>
              @else
              <a href="{{URL::to('/active-slider/'.$slide->id)}}"><span class="text-ellipsis text-success">Hiển thị</span></a>
              @endif
            </td>
            <td><span class="text-ellipsis">12/5/2019</span></td>
            <td>
              <a href="{{URL::to('/edit-slider/'.$slide->id)}}" class="active styling-edit" ui-toggle-class=""><i class="fa fa-pencil-square-o text-success text-active"></i></a>
              <a onclick="return confirm('Bạn chắc chắn muốn xóa {{$slide->slider_name}} không?')"href="{{URL::to('/delete-slider/'.$slide->id)}}" class="active styling-edit" ui-toggle-class=""><i class="fa fa-times text-danger text"></i></a>
            </td>
          </tr>  
          @endforeach     
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection