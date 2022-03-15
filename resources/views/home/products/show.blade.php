@extends('home.layouts.home')

@section('title')
    صفحه فروشگاه
@endsection

@section('script')
    <script>
        $('.variation-select').on('change', function () {
            let variation = JSON.parse(this.value);
            let variationPriceDiv = $('.variation-price');
            variationPriceDiv.empty();

            if (variation.is_sale) {
                let spanSale = $('<span />', {
                    class: 'new',
                    text: toPersianNum(number_format(variation.sale_price)) + ' تومان'
                });
                let spanPrice = $('<span />', {
                    class: 'old',
                    text: toPersianNum(number_format(variation.price)) + ' تومان'
                });

                variationPriceDiv.append(spanSale);
                variationPriceDiv.append(spanPrice);
            } else {
                let spanPrice = $('<span />', {
                    class: 'new',
                    text: toPersianNum(number_format(variation.price)) + ' تومان'
                });
                variationPriceDiv.append(spanPrice);
            }

            $('.quantity-input').attr('data-max', variation.quantity);
            $('.quantity-input').val(1);

        });
    </script>
@endsection

@section('content')

    <div class="breadcrumb-area pt-35 pb-35 bg-gray" style="direction: rtl;">
        <div class="container">
            <div class="breadcrumb-content text-center">
                <ul>
                    <li>
                        <a href="{{route('home.index')}}">صفحه اصلی</a>
                    </li>
                    <li class="active">{{$product->name}}</li>
                </ul>
            </div>
        </div>
    </div>

    <div class="product-details-area pt-100 pb-95">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-6 order-2 order-sm-2 order-md-1" style="direction: rtl;">
                    <div class="product-details-content ml-30">
                        <h2 class="text-right">{{$product->name}}</h2>
                        <div class="product-details-price variation-price">
                            @if($product->quantity_check)
                                @if($product->sale_check)
                                    <span class="new">
                                        {{number_format($product->sale_check->sale_price)}}
                                        تومان
                                    </span>
                                    <span class="old">
                                        {{number_format($product->sale_check->price)}}
                                        تومان
                                    </span>
                                @else
                                    <span class="new">
                                    {{number_format($product->price_check->price)}}
                                    تومان
                                </span>
                                @endif
                            @else
                                <div class="not-in-stock">
                                    <p class="text-white">ناموجود</p>
                                </div>
                            @endif
                        </div>
                        <div class="pro-details-rating-wrap">
                            <div data-rating-stars="5"
                                 data-rating-readonly="true"
                                 data-rating-value="{{ceil($product->rates->avg('rate'))}}">
                            </div>
                            <span class="mx-3">|</span>
                            <span>{{$product->approvedComments()->count()}} دیدگاه </span>
                        </div>
                        <p class="text-right">
                            {{$product->description}}
                        </p>
                        <div class="pro-details-list text-right">
                            <ul>
                                @foreach($product->attributes()->with('attribute')->get() as $attribute)
                                    <li>-
                                        {{$attribute->attribute->name}}
                                        :
                                        {{$attribute->value}}
                                    </li>
                                @endforeach
                            </ul>
                        </div>

                        <form action="{{route('home.cart.add')}}" method="POST">
                            <input type="hidden" name="product_id" value="{{$product->id}}">
                            @csrf
                            @if($product->quantity_check)
                                @php
                                    if($product->sale_check)
                                    {
                                        $variationProductSelected = $product->sale_check;
                                    }else{
                                        $variationProductSelected = $product->price_check;
                                    }
                                @endphp
                                <div class="pro-details-size-color text-right">
                                    <div class="pro-details-size w-50">
                                        <span>{{ App\Models\Attribute::find($product->variations->first()->attribute_id)->name }}</span>
                                        <select name="variation" class="form-control variation-select">
                                            @foreach ($product->variations()->where('quantity' , '>' , 0)->get() as $variation)
                                                <option value="{{ json_encode($variation->only(['id' , 'quantity','is_sale' , 'sale_price' , 'price'])) }}"
                                                    {{ $variationProductSelected->id == $variation->id ? 'selected' : '' }}>{{ $variation->value }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                </div>
                                <div class="pro-details-quality">
                                    <div class="cart-plus-minus">
                                        <input class="cart-plus-minus-box quantity-input" type="text" name="qtybutton" value="1" data-max="5" />
                                    </div>
                                    <div class="pro-details-cart">
                                        <button type="submit">افزودن به سبد خرید</button>
                                    </div>
                                    <div class="pro-details-wishlist">
                                        @auth
                                            @if($product->checkUserWishlist(auth()->id()))
                                                <a href="{{route('home.wishlist.remove',['product'=>$product->id])}}"><i class="fas fa-heart" style="color: red"></i></a>
                                            @else
                                                <a href="{{route('home.wishlist.add',['product'=>$product->id])}}"><i class="sli sli-heart"></i></a>
                                            @endif
                                        @else
                                            <a href="{{route('home.wishlist.add',['product'=>$product->id])}}"><i class="sli sli-heart"></i></a>
                                        @endauth
                                    </div>
                                    <div class="pro-details-compare">
                                        <a title="Add To Compare" href="#"><i class="sli sli-refresh"></i></a>
                                    </div>
                                </div>
                            @else
                                <div class="not-in-stock">
                                    <p class="text-white">ناموجود</p>
                                </div>
                            @endif
                        </form>

                        <div class="pro-details-meta">
                            <span>دسته بندی :</span>
                            <ul>
                                <li>
                                    <a href="#">
                                        {{$product->category->parent->name}}
                                        ,
                                        {{$product->category->name}}
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="pro-details-meta">
                            <span>تگ ها :</span>
                            <ul>
                                @foreach($product->tags as $tag)
                                    <li>
                                        <a href="#">{{$tag->name}}{{$loop->last?'':'،'}}</a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>

                    </div>
                </div>

                <div class="col-lg-6 col-md-6 order-1 order-sm-1 order-md-2">
                    <div class="product-details-img">
                        <div class="zoompro-border zoompro-span">
                            <img class="zoompro" src="{{asset(env('PRODUCT_IMAGES_UPLOAD_PATH').$product->primary_image)}}"
                                 data-zoom-image="{{asset(env('PRODUCT_IMAGES_UPLOAD_PATH').$product->primary_image)}}" alt=""/>

                        </div>
                        <div id="gallery" class="mt-20 product-dec-slider">
                            <a data-image="{{asset(env('PRODUCT_IMAGES_UPLOAD_PATH').$product->primary_image)}}"
                               data-zoom-image="{{asset(env('PRODUCT_IMAGES_UPLOAD_PATH').$product->primary_image)}}">
                                <img width="90" src="{{asset(env('PRODUCT_IMAGES_UPLOAD_PATH').$product->primary_image)}}" alt="">
                            </a>
                            @foreach($product->images as $image)
                            <a data-image="{{asset(env('PRODUCT_IMAGES_UPLOAD_PATH').$image->image)}}"
                               data-zoom-image="{{asset(env('PRODUCT_IMAGES_UPLOAD_PATH').$image->image)}}">
                                <img width="90" src="{{asset(env('PRODUCT_IMAGES_UPLOAD_PATH').$image->image)}}" alt="">
                            </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="description-review-area pb-95">
        <div class="container">
            <div class="row" style="direction: rtl;">
                <div class="col-lg-8 col-md-8">
                    <div class="description-review-wrapper">
                        <div class="description-review-topbar nav">
                            <a class="{{count($errors) > 0 ? '':'active'}}" data-toggle="tab" href="#des-details1"> توضیحات </a>
                            <a data-toggle="tab" href="#des-details3"> اطلاعات بیشتر </a>
                            <a {{count($errors) > 0 ? 'active':''}} data-toggle="tab" href="#des-details2">
                                دیدگاه
                                ({{$product->approvedComments()->count()}})
                            </a>
                        </div>
                        <div class="tab-content description-review-bottom">
                            <div id="des-details1" class="tab-pane {{count($errors) > 0 ? '':'active'}}">
                                <div class="product-description-wrapper">
                                    <p class="text-justify">
                                        {{$product->description}}
                                    </p>
                                </div>
                            </div>
                            <div id="des-details3" class="tab-pane">
                                <div class="product-anotherinfo-wrapper text-right">
                                    <ul>
                                        @foreach($product->attributes()->with('attribute')->get() as $attribute)
                                            <li>
                                                <span>
                                                    {{$attribute->attribute->name}}
                                                    :
                                                </span>
                                                {{$attribute->value}}
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                            <div id="des-details2" class="tab-pane {{count($errors) > 0 ? 'active':''}}">
                                <div class="review-wrapper">
                                    @foreach($product->approvedComments as $comment)
                                        <div class="single-review">
                                            <div class="review-img">
                                                <img src="{{$comment->user->avatar == null ? asset('/images/home/user.png') :$comment->user->avatar}}" alt="">
                                            </div>
                                            <div class="review-content w-100 text-right align-items-center">
                                                <p class="text-right">
                                                    {{$comment->text}}
                                                </p>
                                                <div class="review-top-wrap">
                                                    <div class="review-name">
                                                        <h4> {{$comment->user->name==null? 'کاربر گرامی': $comment->user->name}} </h4>
                                                    </div>
                                                    <div data-rating-stars="5"
                                                         data-rating-readonly="true"
                                                         data-rating-value="{{ceil($comment->user->rates->where('product_id', $product->id)->avg('rate'))}}">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                <div id="comments" class="ratting-form-wrapper text-right">
                                    <span> نوشتن دیدگاه </span>
                                    <div class="my-3" id="dataReadonlyReview"
                                         data-rating-stars="5"
                                         data-rating-value="0"
                                         data-rating-input="#rateInput">
                                    </div>
                                    <div class="ratting-form">
                                        <form action="{{route('home.comments.store',['product'=>$product->id])}}" method="POST">
                                            @csrf
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="rating-form-style mb-20">
                                                        <label> متن دیدگاه : </label>
                                                        <textarea name="text"></textarea>
                                                    </div>
                                                </div>
                                                <input id="rateInput" type="hidden" name="rate" value="0">
                                                <div class="col-lg-12">
                                                    <div class="form-submit">
                                                        <input type="submit" value="ارسال">
                                                    </div>
                                                </div>
                                                <div class="mt-3 text-center w-100">
                                                    @include('home.sections.errors')
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4">
                    <div class="pro-dec-banner">
                        <a href="#">
                            <img src="{{asset('images/home/banner-7.png')}}" alt="">
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

{{--    <div class="product-area pb-70">--}}
{{--        <div class="container">--}}
{{--            <div class="section-title text-center pb-60">--}}
{{--                <h2> محصولات مرتبط </h2>--}}
{{--                <p>--}}
{{--                    لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است.--}}
{{--                    چاپگرها و متون بلکه روزنامه و مجله--}}
{{--                </p>--}}
{{--            </div>--}}
{{--            <div class="arrivals-wrap scroll-zoom">--}}
{{--                <div class="ht-products product-slider-active owl-carousel">--}}
{{--                    <!--Product Start-->--}}
{{--                    <div class="ht-product ht-product-action-on-hover ht-product-category-right-bottom mb-30">--}}
{{--                        <div class="ht-product-inner">--}}
{{--                            <div class="ht-product-image-wrap">--}}
{{--                                <a href="product-details.html" class="ht-product-image">--}}
{{--                                    <img src="assets/img/product/product-1.svg" alt="Universal Product Style"/>--}}
{{--                                </a>--}}
{{--                                <div class="ht-product-action">--}}
{{--                                    <ul>--}}
{{--                                        <li>--}}
{{--                                            <a href="#" data-toggle="modal" data-target="#exampleModal"><i--}}
{{--                                                    class="sli sli-magnifier"></i><span--}}
{{--                                                    class="ht-product-action-tooltip"> مشاهده سریع--}}
{{--                                                    </span></a>--}}
{{--                                        </li>--}}
{{--                                        <li>--}}
{{--                                            <a href="#"><i class="sli sli-heart"></i><span--}}
{{--                                                    class="ht-product-action-tooltip"> افزودن به--}}
{{--                                                        علاقه مندی ها </span></a>--}}
{{--                                        </li>--}}
{{--                                        <li>--}}
{{--                                            <a href="#"><i class="sli sli-refresh"></i><span--}}
{{--                                                    class="ht-product-action-tooltip"> مقایسه--}}
{{--                                                    </span></a>--}}
{{--                                        </li>--}}
{{--                                        <li>--}}
{{--                                            <a href="#"><i class="sli sli-bag"></i><span--}}
{{--                                                    class="ht-product-action-tooltip"> افزودن به سبد--}}
{{--                                                        خرید </span></a>--}}
{{--                                        </li>--}}
{{--                                    </ul>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            <div class="ht-product-content">--}}
{{--                                <div class="ht-product-content-inner">--}}
{{--                                    <div class="ht-product-categories">--}}
{{--                                        <a href="#">لورم</a>--}}
{{--                                    </div>--}}
{{--                                    <h4 class="ht-product-title text-right">--}}
{{--                                        <a href="product-details.html"> لورم ایپسوم </a>--}}
{{--                                    </h4>--}}
{{--                                    <div class="ht-product-price">--}}
{{--                                            <span class="new">--}}
{{--                                                55,000--}}
{{--                                                تومان--}}
{{--                                            </span>--}}
{{--                                        <span class="old">--}}
{{--                                                75,000--}}
{{--                                                تومان--}}
{{--                                            </span>--}}
{{--                                    </div>--}}
{{--                                    <div class="ht-product-ratting-wrap">--}}
{{--                                            <span class="ht-product-ratting">--}}
{{--                                                <span class="ht-product-user-ratting" style="width: 100%;">--}}
{{--                                                    <i class="sli sli-star"></i>--}}
{{--                                                    <i class="sli sli-star"></i>--}}
{{--                                                    <i class="sli sli-star"></i>--}}
{{--                                                    <i class="sli sli-star"></i>--}}
{{--                                                    <i class="sli sli-star"></i>--}}
{{--                                                </span>--}}
{{--                                                <i class="sli sli-star"></i>--}}
{{--                                                <i class="sli sli-star"></i>--}}
{{--                                                <i class="sli sli-star"></i>--}}
{{--                                                <i class="sli sli-star"></i>--}}
{{--                                                <i class="sli sli-star"></i>--}}
{{--                                            </span>--}}
{{--                                    </div>--}}
{{--                                </div>--}}

{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <!--Product End-->--}}
{{--                    <!--Product Start-->--}}
{{--                    <div class="ht-product ht-product-action-on-hover ht-product-category-right-bottom mb-30">--}}
{{--                        <div class="ht-product-inner">--}}
{{--                            <div class="ht-product-image-wrap">--}}
{{--                                <a href="product-details.html" class="ht-product-image">--}}
{{--                                    <img src="assets/img/product/product-2.svg" alt="Universal Product Style"/>--}}
{{--                                </a>--}}
{{--                                <div class="ht-product-action">--}}
{{--                                    <ul>--}}
{{--                                        <li>--}}
{{--                                            <a href="#" data-toggle="modal" data-target="#exampleModal"><i--}}
{{--                                                    class="sli sli-magnifier"></i><span--}}
{{--                                                    class="ht-product-action-tooltip"> مشاهده سریع--}}
{{--                                                    </span></a>--}}
{{--                                        </li>--}}
{{--                                        <li>--}}
{{--                                            <a href="#"><i class="sli sli-heart"></i><span--}}
{{--                                                    class="ht-product-action-tooltip"> افزودن به--}}
{{--                                                        علاقه مندی ها </span></a>--}}
{{--                                        </li>--}}
{{--                                        <li>--}}
{{--                                            <a href="#"><i class="sli sli-refresh"></i><span--}}
{{--                                                    class="ht-product-action-tooltip"> مقایسه--}}
{{--                                                    </span></a>--}}
{{--                                        </li>--}}
{{--                                        <li>--}}
{{--                                            <a href="#"><i class="sli sli-bag"></i><span--}}
{{--                                                    class="ht-product-action-tooltip"> افزودن به سبد--}}
{{--                                                        خرید </span></a>--}}
{{--                                        </li>--}}
{{--                                    </ul>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            <div class="ht-product-content">--}}
{{--                                <div class="ht-product-content-inner">--}}
{{--                                    <div class="ht-product-categories">--}}
{{--                                        <a href="#">لورم </a>--}}
{{--                                    </div>--}}
{{--                                    <h4 class="ht-product-title text-right">--}}
{{--                                        <a href="product-details.html">لورم ایپسوم</a>--}}
{{--                                    </h4>--}}
{{--                                    <div class="ht-product-price">--}}
{{--                                            <span class="new">--}}
{{--                                                25,000--}}
{{--                                                تومان--}}
{{--                                            </span>--}}
{{--                                    </div>--}}
{{--                                    <div class="ht-product-ratting-wrap">--}}
{{--                                            <span class="ht-product-ratting">--}}
{{--                                                <span class="ht-product-user-ratting" style="width: 100%;">--}}
{{--                                                    <i class="sli sli-star"></i>--}}
{{--                                                    <i class="sli sli-star"></i>--}}
{{--                                                    <i class="sli sli-star"></i>--}}
{{--                                                    <i class="sli sli-star"></i>--}}
{{--                                                    <i class="sli sli-star"></i>--}}
{{--                                                </span>--}}
{{--                                                <i class="sli sli-star"></i>--}}
{{--                                                <i class="sli sli-star"></i>--}}
{{--                                                <i class="sli sli-star"></i>--}}
{{--                                                <i class="sli sli-star"></i>--}}
{{--                                                <i class="sli sli-star"></i>--}}
{{--                                            </span>--}}
{{--                                    </div>--}}
{{--                                </div>--}}

{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <!--Product End-->--}}
{{--                    <!--Product Start-->--}}
{{--                    <div class="ht-product ht-product-action-on-hover ht-product-category-right-bottom mb-30">--}}
{{--                        <div class="ht-product-inner">--}}
{{--                            <div class="ht-product-image-wrap">--}}
{{--                                <a href="product-details.html" class="ht-product-image">--}}
{{--                                    <img src="assets/img/product/product-3.svg" alt="Universal Product Style"/>--}}
{{--                                </a>--}}
{{--                                <div class="ht-product-action">--}}
{{--                                    <ul>--}}
{{--                                        <li>--}}
{{--                                            <a href="#" data-toggle="modal" data-target="#exampleModal"><i--}}
{{--                                                    class="sli sli-magnifier"></i><span--}}
{{--                                                    class="ht-product-action-tooltip"> مشاهده سریع--}}
{{--                                                    </span></a>--}}
{{--                                        </li>--}}
{{--                                        <li>--}}
{{--                                            <a href="#"><i class="sli sli-heart"></i><span--}}
{{--                                                    class="ht-product-action-tooltip"> افزودن به--}}
{{--                                                        علاقه مندی ها </span></a>--}}
{{--                                        </li>--}}
{{--                                        <li>--}}
{{--                                            <a href="#"><i class="sli sli-refresh"></i><span--}}
{{--                                                    class="ht-product-action-tooltip"> مقایسه--}}
{{--                                                    </span></a>--}}
{{--                                        </li>--}}
{{--                                        <li>--}}
{{--                                            <a href="#"><i class="sli sli-bag"></i><span--}}
{{--                                                    class="ht-product-action-tooltip"> افزودن به سبد--}}
{{--                                                        خرید </span></a>--}}
{{--                                        </li>--}}
{{--                                    </ul>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            <div class="ht-product-content">--}}
{{--                                <div class="ht-product-content-inner">--}}
{{--                                    <div class="ht-product-categories">--}}
{{--                                        <a href="#">لورم</a>--}}
{{--                                    </div>--}}
{{--                                    <h4 class="ht-product-title text-right">--}}
{{--                                        <a href="product-details.html">لورم ایپسوم</a>--}}
{{--                                    </h4>--}}
{{--                                    <div class="ht-product-price">--}}
{{--                                            <span class="new">--}}
{{--                                                60,000--}}
{{--                                                تومان--}}
{{--                                            </span>--}}
{{--                                        <span class="old">--}}
{{--                                                90,000--}}
{{--                                                تومان--}}
{{--                                            </span>--}}
{{--                                    </div>--}}
{{--                                    <div class="ht-product-ratting-wrap">--}}
{{--                                            <span class="ht-product-ratting">--}}
{{--                                                <span class="ht-product-user-ratting" style="width: 100%;">--}}
{{--                                                    <i class="sli sli-star"></i>--}}
{{--                                                    <i class="sli sli-star"></i>--}}
{{--                                                    <i class="sli sli-star"></i>--}}
{{--                                                    <i class="sli sli-star"></i>--}}
{{--                                                    <i class="sli sli-star"></i>--}}
{{--                                                </span>--}}
{{--                                                <i class="sli sli-star"></i>--}}
{{--                                                <i class="sli sli-star"></i>--}}
{{--                                                <i class="sli sli-star"></i>--}}
{{--                                                <i class="sli sli-star"></i>--}}
{{--                                                <i class="sli sli-star"></i>--}}
{{--                                            </span>--}}
{{--                                    </div>--}}
{{--                                </div>--}}

{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <!--Product End-->--}}
{{--                    <!--Product Start-->--}}
{{--                    <div class="ht-product ht-product-action-on-hover ht-product-category-right-bottom mb-30">--}}
{{--                        <div class="ht-product-inner">--}}
{{--                            <div class="ht-product-image-wrap">--}}
{{--                                <a href="product-details.html" class="ht-product-image">--}}
{{--                                    <img src="assets/img/product/product-4.svg" alt="Universal Product Style"/>--}}
{{--                                </a>--}}
{{--                                <div class="ht-product-action">--}}
{{--                                    <ul>--}}
{{--                                        <li>--}}
{{--                                            <a href="#" data-toggle="modal" data-target="#exampleModal"><i--}}
{{--                                                    class="sli sli-magnifier"></i><span--}}
{{--                                                    class="ht-product-action-tooltip"> مشاهده سریع--}}
{{--                                                    </span></a>--}}
{{--                                        </li>--}}
{{--                                        <li>--}}
{{--                                            <a href="#"><i class="sli sli-heart"></i><span--}}
{{--                                                    class="ht-product-action-tooltip"> افزودن به--}}
{{--                                                        علاقه مندی ها </span></a>--}}
{{--                                        </li>--}}
{{--                                        <li>--}}
{{--                                            <a href="#"><i class="sli sli-refresh"></i><span--}}
{{--                                                    class="ht-product-action-tooltip"> مقایسه--}}
{{--                                                    </span></a>--}}
{{--                                        </li>--}}
{{--                                        <li>--}}
{{--                                            <a href="#"><i class="sli sli-bag"></i><span--}}
{{--                                                    class="ht-product-action-tooltip"> افزودن به سبد--}}
{{--                                                        خرید </span></a>--}}
{{--                                        </li>--}}
{{--                                    </ul>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            <div class="ht-product-content">--}}
{{--                                <div class="ht-product-content-inner">--}}
{{--                                    <div class="ht-product-categories">--}}
{{--                                        <a href="#">لورم</a>--}}
{{--                                    </div>--}}
{{--                                    <h4 class="ht-product-title text-right">--}}
{{--                                        <a href="product-details.html">لورم ایپسوم</a>--}}
{{--                                    </h4>--}}
{{--                                    <div class="ht-product-price">--}}
{{--                                            <span class="new">--}}
{{--                                                60,000--}}
{{--                                                تومان--}}
{{--                                            </span>--}}
{{--                                    </div>--}}
{{--                                    <div class="ht-product-ratting-wrap">--}}
{{--                                            <span class="ht-product-ratting">--}}
{{--                                                <span class="ht-product-user-ratting" style="width: 100%;">--}}
{{--                                                    <i class="sli sli-star"></i>--}}
{{--                                                    <i class="sli sli-star"></i>--}}
{{--                                                    <i class="sli sli-star"></i>--}}
{{--                                                    <i class="sli sli-star"></i>--}}
{{--                                                    <i class="sli sli-star"></i>--}}
{{--                                                </span>--}}
{{--                                                <i class="sli sli-star"></i>--}}
{{--                                                <i class="sli sli-star"></i>--}}
{{--                                                <i class="sli sli-star"></i>--}}
{{--                                                <i class="sli sli-star"></i>--}}
{{--                                                <i class="sli sli-star"></i>--}}
{{--                                            </span>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <!--Product End-->--}}
{{--                    <!--Product Start-->--}}
{{--                    <div class="ht-product ht-product-action-on-hover ht-product-category-right-bottom mb-30">--}}
{{--                        <div class="ht-product-inner">--}}
{{--                            <div class="ht-product-image-wrap">--}}
{{--                                <a href="product-details.html" class="ht-product-image">--}}
{{--                                    <img src="assets/img/product/product-2.svg" alt="Universal Product Style"/>--}}
{{--                                </a>--}}
{{--                                <div class="ht-product-action">--}}
{{--                                    <ul>--}}
{{--                                        <li>--}}
{{--                                            <a href="#" data-toggle="modal" data-target="#exampleModal"><i--}}
{{--                                                    class="sli sli-magnifier"></i><span--}}
{{--                                                    class="ht-product-action-tooltip"> مشاهده سریع--}}
{{--                                                    </span></a>--}}
{{--                                        </li>--}}
{{--                                        <li>--}}
{{--                                            <a href="#"><i class="sli sli-heart"></i><span--}}
{{--                                                    class="ht-product-action-tooltip"> افزودن به--}}
{{--                                                        علاقه مندی ها </span></a>--}}
{{--                                        </li>--}}
{{--                                        <li>--}}
{{--                                            <a href="#"><i class="sli sli-refresh"></i><span--}}
{{--                                                    class="ht-product-action-tooltip"> مقایسه--}}
{{--                                                    </span></a>--}}
{{--                                        </li>--}}
{{--                                        <li>--}}
{{--                                            <a href="#"><i class="sli sli-bag"></i><span--}}
{{--                                                    class="ht-product-action-tooltip"> افزودن به سبد--}}
{{--                                                        خرید </span></a>--}}
{{--                                        </li>--}}
{{--                                    </ul>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            <div class="ht-product-content">--}}
{{--                                <div class="ht-product-content-inner">--}}
{{--                                    <div class="ht-product-categories">--}}
{{--                                        <a href="#">لورم </a>--}}
{{--                                    </div>--}}
{{--                                    <h4 class="ht-product-title text-right">--}}
{{--                                        <a href="product-details.html">لورم ایپسوم</a>--}}
{{--                                    </h4>--}}
{{--                                    <div class="ht-product-price">--}}
{{--                                            <span class="new">--}}
{{--                                                60,000--}}
{{--                                                تومان--}}
{{--                                            </span>--}}
{{--                                    </div>--}}
{{--                                    <div class="ht-product-ratting-wrap">--}}
{{--                                            <span class="ht-product-ratting">--}}
{{--                                                <span class="ht-product-user-ratting" style="width: 100%;">--}}
{{--                                                    <i class="sli sli-star"></i>--}}
{{--                                                    <i class="sli sli-star"></i>--}}
{{--                                                    <i class="sli sli-star"></i>--}}
{{--                                                    <i class="sli sli-star"></i>--}}
{{--                                                    <i class="sli sli-star"></i>--}}
{{--                                                </span>--}}
{{--                                                <i class="sli sli-star"></i>--}}
{{--                                                <i class="sli sli-star"></i>--}}
{{--                                                <i class="sli sli-star"></i>--}}
{{--                                                <i class="sli sli-star"></i>--}}
{{--                                                <i class="sli sli-star"></i>--}}
{{--                                            </span>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <!--Product End-->--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}

    <!-- Modal -->

    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">x</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-7 col-sm-12 col-xs-12" style="direction: rtl;">
                            <div class="product-details-content quickview-content">
                                <h2 class="text-right mb-4">لورم ایپسوم</h2>
                                <div class="product-details-price">
                                        <span>
                                            50,000
                                            تومان
                                        </span>
                                    <span class="old">
                                            75,000
                                            تومان
                                        </span>
                                </div>
                                <div class="pro-details-rating-wrap">
                                    <div class="pro-details-rating">
                                        <i class="sli sli-star yellow"></i>
                                        <i class="sli sli-star yellow"></i>
                                        <i class="sli sli-star yellow"></i>
                                        <i class="sli sli-star"></i>
                                        <i class="sli sli-star"></i>
                                    </div>
                                    <span>3 دیدگاه</span>
                                </div>
                                <p class="text-right">
                                    لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان
                                    گرافیک است. چاپگرها
                                    و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است
                                </p>
                                <div class="pro-details-list text-right">
                                    <ul class="text-right">
                                        <li>- لورم ایپسوم</li>
                                        <li>- لورم ایپسوم متن ساختگی</li>
                                        <li>- لورم ایپسوم متن</li>
                                    </ul>
                                </div>
                                <div class="pro-details-size-color text-right">
                                    <div class="pro-details-size">
                                        <span>Size</span>
                                        <div class="pro-details-size-content">
                                            <ul>
                                                <li><a href="#">s</a></li>
                                                <li><a href="#">m</a></li>
                                                <li><a href="#">l</a></li>
                                                <li><a href="#">xl</a></li>
                                                <li><a href="#">xxl</a></li>
                                            </ul>
                                        </div>
                                    </div>

                                    <div class="pro-details-color-wrap">
                                        <span>Color</span>
                                        <div class="pro-details-color-content">
                                            <ul>
                                                <li class="blue"></li>
                                                <li class="maroon active"></li>
                                                <li class="gray"></li>
                                                <li class="green"></li>
                                                <li class="yellow"></li>
                                                <li class="white"></li>
                                            </ul>
                                        </div>
                                    </div>

                                </div>
                                <div class="pro-details-quality">
                                    <div class="cart-plus-minus">
                                        <input class="cart-plus-minus-box" type="text" name="qtybutton" value="2"/>
                                    </div>
                                    <div class="pro-details-cart">
                                        <button type="submit">افزودن به سبد خرید</button>
                                    </div>
                                    <div class="pro-details-wishlist">
                                        <a title="Add To Wishlist" href="#"><i class="sli sli-heart"></i></a>
                                    </div>
                                    <div class="pro-details-compare">
                                        <a title="Add To Compare" href="#"><i class="sli sli-refresh"></i></a>
                                    </div>
                                </div>
                                <div class="pro-details-meta">
                                    <span>دسته بندی :</span>
                                    <ul>
                                        <li><a href="#">پالتو</a></li>
                                    </ul>
                                </div>
                                <div class="pro-details-meta">
                                    <span>تگ ها :</span>
                                    <ul>
                                        <li><a href="#">لباس, </a></li>
                                        <li><a href="#">پیراهن</a></li>
                                        <li><a href="#">مانتو</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-5 col-sm-12 col-xs-12">
                            <div class="tab-content quickview-big-img">
                                <div id="pro-1" class="tab-pane fade show active">
                                    <img src="assets/img/product/quickview-l1.svg" alt=""/>
                                </div>
                                <div id="pro-2" class="tab-pane fade">
                                    <img src="assets/img/product/quickview-l2.svg" alt=""/>
                                </div>
                                <div id="pro-3" class="tab-pane fade">
                                    <img src="assets/img/product/quickview-l3.svg" alt=""/>
                                </div>
                                <div id="pro-4" class="tab-pane fade">
                                    <img src="assets/img/product/quickview-l2.svg" alt=""/>
                                </div>
                            </div>
                            <!-- Thumbnail Large Image End -->
                            <!-- Thumbnail Image End -->
                            <div class="quickview-wrap mt-15">
                                <div class="quickview-slide-active owl-carousel nav nav-style-2" role="tablist">
                                    <a class="active" data-toggle="tab" href="#pro-1"><img
                                            src="assets/img/product/quickview-s1.svg" alt=""/></a>
                                    <a data-toggle="tab" href="#pro-2"><img
                                            src="assets/img/product/quickview-s2.svg" alt=""/></a>
                                    <a data-toggle="tab" href="#pro-3"><img
                                            src="assets/img/product/quickview-s3.svg" alt=""/></a>
                                    <a data-toggle="tab" href="#pro-4"><img
                                            src="assets/img/product/quickview-s2.svg" alt=""/></a>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal end -->

@endsection
