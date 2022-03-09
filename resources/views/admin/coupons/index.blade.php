@extends('admin.layouts.admin')

@section('title')
    نمایش کوپن ها
@endsection

@section('content')
    <div class="row">
        <div class="col-xl-12 col-md-12 mb-4 p-md-5 bg-white">
            <div class="d-flex justify-content-between mb-4">
                <h5 class=""> لیست کوپن ها ({{$coupons->total()}})</h5>
                <a class="btn btn-sm btn-outline-primary" href="{{route('admin.coupons.create')}}">
                    <i class="fa fa-plus"></i>
                    ایجاد کوپن
                </a>
            </div>
            <div class="">
                <table class="table table-bordered table-striped text-center">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>نام</th>
                        <th>کد</th>
                        <th>نوع</th>
                        <th>تاریخ انقضا</th>
                        <th>عملیات</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($coupons as $key=>$coupon)
                        <tr>
                            <th>{{$coupons->firstItem()+$key}}</th>
                            <th>{{$coupon->name}}</th>
                            <th>{{$coupon->code}}</th>
                            <th class="{{ $coupon->getRawOriginal('type') ? 'text-success' : 'text-danger' }}">{{$coupon->type}}</th>
                            <th>{{verta($coupon->expired_at)}}</th>
                            <th>
                                <a class="btn btn-sm btn-success" href="{{route('admin.coupons.show',['coupon'=>$coupon->id])}}">نمایش</a>
                                <a class="btn btn-sm btn-info" href="{{route('admin.coupons.edit',['coupon'=>$coupon->id])}}">ویرایش</a>
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
