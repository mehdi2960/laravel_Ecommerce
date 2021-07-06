@extends('admin.layouts.admin')

@section('title')
   نمایش برندها
@endsection

@section('content')
    <div class="row">
        <div class="col-xl-12 col-md-12 mb-4 p-md-5 bg-white">
            <div class="mb-4">
                <h5 class="">: برند{{$brand->name}} </h5>
            </div>
            <hr>
                <div class="row">
                    <div class="form-group col-md-3">
                        <label>نام</label>
                        <input type="text" class="form-control" value="{{($brand->name)}}" disabled>
                    </div>

                    <div class="form-group col-md-3">
                        <label>وضیعت</label>
                        <input type="text" class="form-control" value="{{($brand->is_active)}}" disabled>
                    </div>

                    <div class="form-group col-md-3">
                        <label>تاریخ ایجاد</label>
                        <input type="text" class="form-control" value="{{verta($brand->created_at)}}" disabled>
                    </div>
                </div>
                <a href="{{route('admin.brands.index')}}" class="btn btn-dark mt-5">بازگشت</a>
        </div>
    </div>
    </div>
@endsection
