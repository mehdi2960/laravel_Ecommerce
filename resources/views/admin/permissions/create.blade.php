@extends('admin.layouts.admin')

@section('title')
   ایجاد پرمیژن
@endsection

@section('content')
    <div class="row">
        <div class="col-xl-12 col-md-12 mb-4 p-md-5 bg-white">
            <div class="mb-4">
                <h5 class="">ایجاد پرمیژن</h5>
            </div>
            <hr>
            @include('admin.sections.errors')
            <form action="{{route('admin.permissions.store')}}" method="post">
                @csrf
                <div class="form-row">
                    <div class="form-group col-md-3">
                        <label for="display_name">نام نمایشی</label>
                        <input type="text" name="display_name" class="form-control" value="{{old('display_name')}}">
                    </div>
                    <div class="form-group col-md-3">
                        <label for="name">نام</label>
                        <input type="text" name="name" class="form-control" value="{{old('name')}}">
                    </div>
                </div>
                <button type="submit" class="btn btn-outline-primary mt-5">ثبت</button>
                <a href="{{route('admin.permissions.index')}}" class="btn btn-dark mr-3 mt-5">بازگشت</a>
            </form>
        </div>
    </div>
    </div>
@endsection
