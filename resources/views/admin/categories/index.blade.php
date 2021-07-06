@extends('admin.layouts.admin')

@section('title')
    نمایش دسته بندی ها
@endsection

@section('content')
    <div class="row">
        <div class="col-xl-12 col-md-12 mb-4 p-md-5 bg-white">
            <div class="d-flex justify-content-between mb-4">
                <h5 class=""> لیست دسته بندی ها ({{$categories->total()}})</h5>
                <a class="btn btn-sm btn-outline-primary" href="{{route('admin.categories.create')}}">
                    <i class="fa fa-plus"></i>
                    ایجاد دسته بندی
                </a>
            </div>
            <div class="">
                <table class="table table-bordered table-striped text-center">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>نام</th>
                        <th>نام انگلیسی</th>
                        <th>والد</th>
                        <th>وضیعت</th>
                        <th>عملیات</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($categories as $key=>$category)
                        <tr>
                            <th>{{$categories->firstItem()+$key}}</th>
                            <th>{{$category->name}}</th>
                            <th>{{$category->slug}}</th>
                            @if ($category->parent_id==0)
                            <th>بدون والد</th>
                            @else
                            <th>{{$category->parent->name}}</th>
                            @endif
                            <th>
                                <span class="{{$category->getRawOriginal('is_active')?'text-success':'text-danger'}}">
                                {{$category->is_active}}
                                </span>
                            </th>
                            <th>
                                <a class="btn btn-sm btn-success" href="{{route('admin.categories.show',['category'=>$category->id])}}">نمایش</a>
                                <a class="btn btn-sm btn-info" href="{{route('admin.categories.edit',['category'=>$category->id])}}">ویرایش</a>

                            </th>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    </div>

@endsection
