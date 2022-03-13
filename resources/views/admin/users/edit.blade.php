@extends('admin.layouts.admin')

@section('title')
   ویرایش کاربران
@endsection

@section('content')
    <div class="row">
        <div class="col-xl-12 col-md-12 mb-4 p-md-5 bg-white">
            <div class="mb-4">
                <h5 class="">ویرایش کاربر: {{$user->name}}</h5>
            </div>
            <hr>
            @include('admin.sections.errors')
            <form action="{{route('admin.users.update',['user'=>$user->id])}}" method="post">
                @csrf
                @method('put')
                <div class="form-row">
                    <div class="form-group col-md-3">
                        <label for="name">نام</label>
                        <input type="text" id="name" name="name" class="form-control" value="{{$user->name}}">
                    </div>
                    <div class="form-group col-md-3">
                        <label for="cellphone">شماره تلفن</label>
                        <input type="text" id="cellphone" name="cellphone" class="form-control" value="{{$user->cellphone}}">
                    </div>
                </div>
                <button type="submit" class="btn btn-outline-primary mt-5">ویرایش</button>
                <a href="{{route('admin.users.index')}}" class="btn btn-dark mr-3 mt-5">بازگشت</a>
            </form>
        </div>
    </div>
    </div>
@endsection
