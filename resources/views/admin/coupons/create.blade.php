@extends('admin.layouts.admin')

@section('title')
    ایجاد کوپن تخفیف
@endsection

@section('script')
    <script>
        $(`#expireDate`).MdPersianDateTimePicker({
            targetTextSelector: `#expireInput`,
            englishNumber: true,
            enableTimePicker: true,
            textFormat: 'yyyy-MM-dd HH:mm:ss',
        });
    </script>
@endsection

@section('content')
    <div class="row">
        <div class="col-xl-12 col-md-12 mb-4 p-md-5 bg-white">
            <div class="mb-4">
                <h5 class="">ایجاد کوپن</h5>
            </div>
            <hr>
            @include('admin.sections.errors')
            <form action="{{route('admin.coupons.store')}}" method="post">
                @csrf
                <div class="form-row">
                    <div class="form-group col-md-3">
                        <label for="name">نام</label>
                        <input type="text" id="name" name="name" class="form-control" value="{{old('name')}}">
                    </div>

                    <div class="form-group col-md-3">
                        <label for="code">کد</label>
                        <input type="text" id="code" name="code" class="form-control" value="{{old('code')}}">
                    </div>

                    <div class="form-group col-md-3">
                        <label for="type">نوع</label>
                        <select name="type" id="type" class="form-control">
                            <option value="amount">مبلغی</option>
                            <option value="persentage">درصدی</option>
                        </select>
                    </div>

                    <div class="form-group col-md-3">
                        <label for="amount">مبلغ</label>
                        <input type="text" id="amount" name="amount" class="form-control" value="{{old('amount')}}">
                    </div>

                    <div class="form-group col-md-3">
                        <label for="percentage">درصدی</label>
                        <input type="text" id="percentage" name="percentage" class="form-control" value="{{old('percentage')}}">
                    </div>

                    <div class="form-group col-md-3">
                        <label for="max_percentage_amount">حداقل مبلغ برای نوع درصدی</label>
                        <input type="text" id="max_percentage_amount" name="max_percentage_amount" class="form-control" value="{{old('max_percentage_amount')}}">
                    </div>

                    <div class="form-group col-md-3">
                        <label> تاریخ انقضا </label>
                        <div class="input-group">
                            <div class="input-group-prepend order-2">
                                <span class="input-group-text" id="expireDate">
                                    <i class="fas fa-clock"></i>
                                </span>
                            </div>
                            <input type="text" class="form-control" id="expireInput" name="expired_at">
                        </div>
                    </div>

                    <div class="form-group col-md-12">
                        <label for="description">توضیحات</label>
                        <textarea class="form-control" id="description" name="description">{{ old('description') }}</textarea>
                    </div>

                </div>
                <button type="submit" class="btn btn-outline-primary mt-5">ثبت</button>
                <a href="{{route('admin.coupons.index')}}" class="btn btn-dark mr-3 mt-5">بازگشت</a>
            </form>
        </div>
    </div>
    </div>
@endsection
