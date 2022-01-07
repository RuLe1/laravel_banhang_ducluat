@extends('admin_layout')
@section('content')

<div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
            Cập nhật danh mục sản phẩm
            </header>
            <div class="panel-body">
                <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif             
                </div>
                @foreach($edit_category as $key => $edit)
                <div class="position-center">
                    <form role="form" action="{{URL::to('/update-category-product/'.$edit->id)}}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="exampleInputEmail1">Tên danh mục</label>
                            <input type="text" value="{{$edit->category_name}}"name="category_product_name" 
                            class="form-control" id="exampleInputEmail1" placeholder="Tên danh mục">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Mô tả danh mục</label>
                            <textarea style="resize:none" rows="5" class="form-control" name="category_product_desc"
                             id="exampleInputPassword1" placeholder="Mô tả danh mục">{{$edit->category_desc}}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Từ khóa danh mục</label>
                            <textarea style="resize:none" rows="5" class="form-control" name="category_product_keywords" id="exampleInputPassword1" placeholder="Mô tả danh mục">
                            {{$edit->meta_keywords}}
                            </textarea>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputFile">Thuộc danh mục</label>
                            <select name="category_product_parent"class="form-control input-sm m=bot15">
                                <option value="0">--------Danh mục cha--------</option>
                                @foreach($category_product as $key => $val)
                                    @if($val->category_parent == 0)
                                        <option {{$val->id == $edit->category_parent ? 'selected' :''}} value="{{$val->id}}">{{$val->category_name}}</option>
                                    @endif
                                    @foreach($category_product as $key => $val2)
                                        @if($val2->category_parent == $val->id)
                                            <option {{$val2->id == $edit->category_parent ? 'selected' :''}} value="{{$val2->id}}">==Danh mục con=={{$val2->category_name}}</option>
                                        @endif
                                    @endforeach
                                @endforeach
                            </select>
                        </div>
                        <button type="submit"name="update_category_product" class="btn btn-info">Cập nhật</button>
                    </form>
                </div>
                @endforeach
            </div>
        </section>
    </div>

@endsection