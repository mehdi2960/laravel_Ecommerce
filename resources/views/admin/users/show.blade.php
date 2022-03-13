@extends('admin.layouts.admin')

@section('title')
   نمایش ویژگی ها
@endsection

@section('content')
    <div class="row">
        <div class="col-xl-12 col-md-12 mb-4 p-md-5 bg-white">
            <div class="mb-4">
                <h5 class="">: ویژگی ها {{$attribute->name}} </h5>
            </div>
            <hr>
                <div class="row">
                    <div class="form-group col-md-3">
                        <label>نام</label>
                        <input type="text" class="form-control" value="{{($attribute->name)}}" disabled>
                    </div>

                    <div class="form-group col-md-3">
                        <label>تاریخ ایجاد</label>
                        <input type="text" class="form-control" value="{{verta($attribute->created_at)}}" disabled>
                    </div>
                </div>
                <a href="{{route('admin.attributes.index')}}" class="btn btn-dark mt-5">بازگشت</a>
        </div>
    </div>
    </div>
@endsection
