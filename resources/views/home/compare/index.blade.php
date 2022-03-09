@extends('home.layouts.home')

@section('title')
    صفحه مقایسه
@endsection

@section('content')

    <div class="breadcrumb-area pt-35 pb-35 bg-gray" style="direction: rtl;">
        <div class="container">
            <div class="breadcrumb-content text-center">
                <ul>
                    <li>
                        <a href="{{ route('home.index') }}"> صفحه اصلی </a>
                    </li>
                    <li class="active"> مقایسه محصول </li>
                </ul>
            </div>
        </div>
    </div>

    <!-- compare main wrapper start -->
    <div class="compare-page-wrapper pt-100 pb-100" style="direction: rtl;">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <!-- Compare Page Content Start -->
                    <div class="compare-page-content-wrap">
                        <div class="compare-table table-responsive">
                            <table class="table table-bordered mb-0">
                                <tbody>
                                <tr>
                                    <td class="first-column"> محصول </td>
                                    @foreach ($products as $product)
                                        <td class="product-image-title">
                                            <a href="single-product.html" class="image">
                                                <img width="200" class="img-fluid" src="{{ asset(env('PRODUCT_IMAGES_UPLOAD_PATH') . $product->primary_image) }}"
                                                     alt="Compare Product">
                                            </a>
                                            <a href="{{ route('home.categories.show' , ['category' => $product->category->slug ]) }}" class="category"> {{ $product->category->name }} </a>
                                            <a href="#" class="title"> {{ $product->name }} </a>
                                        </td>
                                    @endforeach
                                </tr>
                                <tr>
                                    <td class="first-column"> توضیحات </td>
                                    @foreach ($products as $product)
                                        <td class="pro-desc">
                                            <p class="text-right">
                                                {{ $product->description }}
                                            </p>
                                        </td>
                                    @endforeach
                                </tr>

                                <tr>
                                    <td class="first-column"> ویژگی متغییر </td>
                                    @foreach ($products as $product)
                                        <td>
                                            <ul class="text-right">
                                                <li>
                                                    {{ App\Models\Attribute::find($product->variations->first()->attribute_id)->name }}
                                                    :
                                                    @foreach ($product->variations()->where('quantity' , '>' , 0)->get() as $variation)
                                                        <span>{{ $variation->value }} {{ $loop->last ? '' : '،' }}</span>
                                                    @endforeach
                                                </li>
                                            </ul>
                                        </td>
                                    @endforeach
                                </tr>
                                <tr>
                                    <td class="first-column"> ویژگی </td>
                                    @foreach ($products as $product)
                                        <td>
                                            <ul class="text-right">
                                                @foreach ($product->attributes()->with('attribute')->get() as $attribute)
                                                    <li> -
                                                        {{ $attribute->attribute->name }}
                                                        :
                                                        {{ $attribute->value }}
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </td>
                                    @endforeach
                                </tr>
                                <tr>
                                    <td class="first-column"> امتیاز </td>
                                    @foreach ($products as $product)
                                        <td>
                                            <div data-rating-stars="5"
                                                 data-rating-readonly="true"
                                                 data-rating-value="{{ ceil($product->rates->avg('rate')) }}">
                                            </div>
                                        </td>
                                    @endforeach
                                </tr>
                                <tr>
                                    <td class="first-column"> حذف </td>
                                    @foreach ($products as $product)
                                        <td class="pro-remove">
                                            <a href="{{ route('home.compare.remove' , ['product' => $product->id]) }}"><i class="sli sli-trash"></i></a>
                                        </td>
                                    @endforeach

                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- Compare Page Content End -->
                </div>
            </div>
        </div>
    </div>
    <!-- compare main wrapper end -->

@endsection
