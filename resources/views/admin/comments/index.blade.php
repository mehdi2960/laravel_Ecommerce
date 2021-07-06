@extends('admin.layouts.admin')

@section('title')
    نمایش کامنت ها
@endsection

@section('content')
    <div class="row">
        <div class="col-xl-12 col-md-12 mb-4 p-md-5 bg-white">
            <div class="d-flex justify-content-between mb-4">
                <h5 class=""> لیست کامنت ها ({{$comments->total()}})</h5>
            </div>
            <div class="">
                <table class="table table-bordered table-striped text-center">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>نام کاربر</th>
                        <th>نام محصول</th>
                        <th>متن کامنت</th>
                        <th>وضیعت</th>
                        <th>عملیات</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($comments as $key=>$comment)
                        <tr>
                            <th>{{$comments->firstItem()+$key}}</th>

                            <th>
                                {{--<a href="">--}}
                                {{$comment->user->name==null?$comment->user->cellphone:$comment->user->name}}
                                {{--</a>--}}
                            </th>

                            <th>
                                <a href="{{route('admin.products.show',['product'=>$comment->product->id])}}">
                                    {{$comment->product->name}}
                                </a>

                            </th>
                            <th>{{$comment->text}}</th>

                            <th class="{{$comment->getRowOriginal('approved')?'text-success':'text-danger'}}">
                                {{$comment->approved}}
                            </th>
                            <th>
                                <a class="btn btn-sm btn-success"
                                   href="{{route('admin.comments.show',['comment'=>$comment->id])}}">نمایش</a>

                                <form action="{{route('admin.comments.destroy',['comment'=>$comment->id])}}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger">حذف</button>

                                </form>

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
