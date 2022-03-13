@extends('admin.layouts.admin')

@section('title')
    نمایش کاربران
@endsection

@section('content')
    <div class="row">
        <div class="col-xl-12 col-md-12 mb-4 p-md-5 bg-white">
            <div class="d-flex justify-content-between mb-4">
                <h5 class=""> لیست کاربران ({{$users->total()}})</h5>
            </div>
            <div class="">
                <table class="table table-bordered table-striped text-center">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>نام</th>
                        <th>ایمیل</th>
                        <th>شماره تلفن</th>
                        <th>عملیات</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($users as $key=>$user)
                        <tr>
                            <th>{{$users->firstItem()+$key}}</th>
                            <th>{{$user->name}}</th>
                            <th>{{$user->email}}</th>
                            <th>{{$user->cellphone}}</th>
                            <th>
{{--                                <form action="{{ route('admin.users.destroy', ['user' => $user->id]) }}" method="POST">--}}
{{--                                    @csrf--}}
{{--                                    @method('DELETE')--}}

{{--                                    <button class="btn btn-sm btn-outline-danger" type="submit">حذف</button>--}}
{{--                                </form>--}}
                                <a class="btn btn-sm btn-outline-info mr-3 mt-2"
                                   href="{{ route('admin.users.edit', ['user' => $user->id]) }}">
                                    ویرایش
                                </a>
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
