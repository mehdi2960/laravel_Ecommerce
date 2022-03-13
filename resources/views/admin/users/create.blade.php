@extends('admin.layouts.admin')

@section('title')
   ایجاد کاربران
@endsection

@section('content')
    <div class="row">
        <div class="col-xl-12 col-md-12 mb-4 p-md-5 bg-white">
            <div class="mb-4">
                <h5 class="">ایجاد کاربر</h5>
            </div>
            <hr>
            @include('admin.sections.errors')
            <form action="{{route('admin.users.store')}}" method="post">
                @csrf
                <div class="form-row">
                    <div class="form-group col-md-3">
                        <label for="name">نام</label>
                        <input type="text" id="name" name="name" class="form-control">
                    </div>
                </div>
                <button type="submit" class="btn btn-outline-primary mt-5">ثبت</button>
                <a href="{{route('admin.users.index')}}" class="btn btn-dark mr-3 mt-5">بازگشت</a>
            </form>
        </div>
    </div>
    </div>
@endsection
