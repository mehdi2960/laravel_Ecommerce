@extends('admin.layouts.admin')

@section('title')
    index social
@endsection

@section('content')

    <!-- Content Row -->
    <div class="row">

        <div class="col-xl-12 col-md-12 mb-4 p-4 bg-white">
            <div class="d-flex flex-column text-center flex-md-row justify-content-md-between mb-4">
                <h5 class="font-weight-bold mb-3 mb-md-0">لیست شبکه های اجتماعی ({{ $socials->total() }})</h5>
                <a class="btn btn-sm btn-outline-primary" href="{{ route('admin.socials.create') }}">
                    <i class="fa fa-plus"></i>
                    ایجاد شبکه های اجتماعی
                </a>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered table-striped text-center">

                    <thead>
                        <tr>
                            <th>#</th>
                            <th>عنوان</th>
                            <th>لینک</th>
                            <th>وضعیت</th>
                            <th>عملیات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($socials as $key => $social)
                            <tr>
                                <th>
                                    {{ $socials->firstItem() + $key }}
                                </th>
                                <th>
                                    {{ $social->title }}
                                </th>
                                <th>
                                    {{ $social->link }}
                                </th>
                                <th>
                                    <span class="{{ $social->getRawOriginal('is_active') ? 'text-success' : 'text-danger' }}">
                                        {{ $social->is_active }}
                                    </span>
                                </th>
                                <th>
                                    <form action="{{ route('admin.socials.destroy', ['social' => $social->id]) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger" type="submit">حذف</button>
                                    </form>
                                    <a class="btn btn-sm btn-outline-info mr-3 mt-2"
                                        href="{{ route('admin.socials.edit', ['social' => $social->id]) }}">ویرایش</a>
                                </th>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-center mt-5">
                {{ $socials->render() }}
            </div>
        </div>
    </div>
@endsection
