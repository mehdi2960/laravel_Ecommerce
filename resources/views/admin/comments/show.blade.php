@extends('admin.layouts.admin')

@section('title')
    نمایش کامنت ها
@endsection

@section('content')
    <div class="row">
        <div class="col-xl-12 col-md-12 mb-4 p-md-5 bg-white">
            <div class="mb-4">
                <h5 class=""> کامنت ها </h5>
            </div>
            <hr>
            <div class="row">
                <div class="form-group col-md-3">
                    <label>نام کاربر</label>
                    <input type="text" class="form-control"
                           value="{{($comment->user->name==null?$comment->user->cellphone:$comment->user->name)}}" disabled>
                </div>

                <div class="form-group col-md-3">
                    <label>نام محصول</label>
                    <input type="text" class="form-control" value="{{($comment->product->name)}}" disabled>
                </div>

                <div class="form-group col-md-3">
                    <label>وضیعت</label>
                    <input type="text" class="form-control" value="{{($comment->approved)}}" disabled>
                </div>

                <div class="form-group col-md-3">
                    <label>تاریخ ایجاد</label>
                    <input type="text" class="form-control" value="{{verta($comment->created_at)}}" disabled>
                </div>

                <div class="form-group col-md-12">
                    <label>متن</label>
                    <textarea class="form-control" name="text" rows="10">{{$comment->text}}</textarea>
                </div>
            </div>
            <a href="{{route('admin.comments.index')}}" class="btn btn-dark mt-5">بازگشت</a>
            @if($comment->getRawOriginal('approved'))
                <a href="{{route('admin.comments.change-approve',['comment'=>$comment->id])}}" class="btn btn-danger mt-5">عدم تایید</a>
            @else
                <a href="{{route('admin.comments.change-approve' ,['comment'=>$comment->id])}}" class="btn btn-success mt-5">تایید</a>
            @endif
        </div>
    </div>
    </div>
@endsection
