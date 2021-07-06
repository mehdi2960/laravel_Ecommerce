@extends('admin.layouts.admin')

@section('title')
    index tags
@endsection

@section('content')

    <!-- Content Row -->
    <div class="row">

        <div class="col-xl-12 col-md-12 mb-4 p-md-5 bg-white">
            <div class="d-flex justify-content-between mb-4">
                <h5 class="font-weight-bold">لیست تگ ها ({{ $tags->total() }})</h5>
                <a class="btn btn-sm btn-outline-primary" href="{{ route('admin.tags.create') }}">
                    <i class="fa fa-plus"></i>
                    ایجاد تگ
                </a>
            </div>

            <div>
                <table class="table table-bordered table-striped text-center">

                    <thead>
                        <tr>
                            <th>#</th>
                            <th>نام</th>
                            <th>عملیات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($tags as $key => $tag)
                            <tr>
                                <th>
                                    {{ $tags->firstItem() + $key }}
                                </th>
                                <th>
                                    {{ $tag->name }}
                                </th>
                                <th>
                                    <a class="btn btn-sm btn-outline-success"
                                        href="{{ route('admin.tags.show', ['tag' => $tag->id]) }}">نمایش</a>
                                    <a class="btn btn-sm btn-outline-info mr-3"
                                        href="{{ route('admin.tags.edit', ['tag' => $tag->id]) }}">ویرایش</a>
                                </th>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

   </div>
@endsection
