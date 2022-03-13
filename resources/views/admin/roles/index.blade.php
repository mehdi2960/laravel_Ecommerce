@extends('admin.layouts.admin')

@section('title')
    نمایش پرمیژن ها
@endsection

@section('content')
    <div class="row">
        <div class="col-xl-12 col-md-12 mb-4 p-md-5 bg-white">
            <div class="d-flex justify-content-between mb-4">
                <h5 class=""> لیست پرمیژن ها ({{$permissions->total()}})</h5>
                <a class="btn btn-sm btn-outline-primary" href="{{route('admin.permissions.create')}}">
                    <i class="fa fa-plus"></i>
                    ایجاد پرمیژن
                </a>
            </div>
            <div class="">
                <table class="table table-bordered table-striped text-center">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>نام نمایشی</th>
                        <th>نام</th>
                        <th>عملیات</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($permissions as $key=>$permission)
                        <tr>
                            <th>{{$permissions->firstItem()+$key}}</th>
                            <th>{{$permission->display_name}}</th>
                            <th>{{$permission->name}}</th>
                            <th>
                                <a class="btn btn-sm btn-success" href="{{route('admin.permissions.show',['permission'=>$permission->id])}}">نمایش</a>
                                <a class="btn btn-sm btn-info" href="{{route('admin.permissions.edit',['permission'=>$permission->id])}}">ویرایش</a>

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
