@extends('admin.layouts.admin')

@section('title')
   ویرایش برند
@endsection

@section('content')
    <div class="row">
        <div class="col-xl-12 col-md-12 mb-4 p-md-5 bg-white">
            <div class="mb-4">
                <h5 class="">ویرایش برند</h5>
            </div>
            <hr>
            @include('admin.sections.errors')
            <form action="{{route('admin.brands.update',['brand'=>$brand->id])}}" method="post">
                @csrf
                @method('put')
                <div class="form-row">
                    <div class="form-group col-md-3">
                        <label for="name">نام</label>
                        <input type="text" id="name" name="name" class="form-control" value="{{$brand->name}}">
                    </div>
                    <div class="form-group col-md-3">
                        <label for="is_active">وضیعت</label>
                        <select class="form-control" name="is_active" id="is_active">
                            <option value="1" {{$brand->getRawOriginal('is_active')?'selected':""}}>فعال</option>
                            <option value="0" {{$brand->getRawOriginal('is_active')?'selected':""}}>غیر فعال</option>
                        </select>
                    </div>
                </div>
                <button type="submit" class="btn btn-outline-primary mt-5">ویرایش</button>
                <a href="{{route('admin.brands.index')}}" class="btn btn-dark mr-3 mt-5">بازگشت</a>
            </form>
        </div>
    </div>
    </div>
@endsection
