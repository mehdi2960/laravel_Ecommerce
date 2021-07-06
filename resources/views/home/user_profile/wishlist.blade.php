@extends('home.layouts.home')

@section('title')
    صفحه لیست علاقه مندی ها
@endsection

@section('content')

    <div class="breadcrumb-area pt-35 pb-35 bg-gray" style="direction: rtl;">
        <div class="container">
            <div class="breadcrumb-content text-center">
                <ul>
                    <li>
                        <a href="{{route('home.index')}}">صفحه اصلی</a>
                    </li>
                    <li class="active">  لیست علاقه مندی ها </li>
                </ul>
            </div>
        </div>
    </div>

    <!-- my account wrapper start -->
    <div class="my-account-wrapper pt-100 pb-100">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">

                    <div class="myaccount-page-wrapper">

                        <div class="row text-right" style="direction: rtl;">
                            <div class="col-lg-3 col-md-4">
                               @include('home.sections.profile_sidebar')
                            </div>
                            <div class="col-lg-9 col-md-8">
                                <div class="tab-content" id="myaccountContent">
                                    <div class="myaccount-content">
                                        <h3>  لیست علاقه مندی ها</h3>
                                        <div class="review-wrapper">
                                            @if($wishlists->isEmpty())
                                                <div class="alert alert-danger text-center">لیست علاقه مندیهای شما خالی می باشد</div>
                                            @else
                                                <div class="table-content table-responsive cart-table-content">
                                                    <table>
                                                        <thead>
                                                        <tr>
                                                            <th> تصویر محصول </th>
                                                            <th> نام محصول </th>
                                                            <th> حذف </th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        @foreach($wishlists as $wishlist)
                                                            <tr>
                                                                <td class="product-thumbnail">
                                                                    <a href="{{route('home.products.show' ,['product'=> $wishlist->product->slug])}}">
                                                                        <img width="100" src="{{route(env('PRODUCT_IMAGES_UPLOAD_PATH').$wishlist->product->primary_image)}}" alt="">
                                                                    </a>
                                                                </td>
                                                                <td class="product-name">
                                                                    <a href="{{route('home.products.show' ,['product'=> $wishlist->product->slug])}}">
                                                                        {{$wishlist->product->name}}
                                                                    </a>
                                                                </td>
                                                                <td class="product-name">
                                                                    <a href="{{route('home.wishlist.remove' ,['product'=>$wishlist->product->id])}}">
                                                                        <i class="sli sli-trash" style="font-size: 20px"></i>
                                                                    </a>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- my account wrapper end -->

    <!-- Modal Order -->
    <div class="modal fade" id="ordersDetiles" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">x</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12" style="direction: rtl;">
                            <form action="#">
                                <div class="table-content table-responsive cart-table-content">
                                    <table>
                                        <thead>
                                        <tr>
                                            <th> تصویر محصول </th>
                                            <th> نام محصول </th>
                                            <th> فی </th>
                                            <th> تعداد </th>
                                            <th> قیمت کل </th>
                                        </tr>
                                        </thead>
                                        <tbody>

                                        <tr>
                                            <td class="product-thumbnail">
                                                <a href="#"><img src="assets/img/cart/cart-3.svg" alt=""></a>
                                            </td>
                                            <td class="product-name"><a href="#"> لورم ایپسوم </a></td>
                                            <td class="product-price-cart"><span class="amount">
                                                            20000
                                                            تومان
                                                        </span></td>
                                            <td class="product-quantity">
                                                2
                                            </td>
                                            <td class="product-subtotal">
                                                40000
                                                تومان
                                            </td>
                                        </tr>

                                        <tr>
                                            <td class="product-thumbnail">
                                                <a href="#"><img src="assets/img/cart/cart-4.svg" alt=""></a>
                                            </td>
                                            <td class="product-name"><a href="#"> لورم ایپسوم متن ساختگی </a>
                                            </td>
                                            <td class="product-price-cart"><span class="amount">
                                                            10000
                                                            تومان
                                                        </span></td>
                                            <td class="product-quantity">
                                                3
                                            </td>
                                            <td class="product-subtotal">
                                                30000
                                                تومان
                                            </td>
                                        </tr>

                                        <tr>
                                            <td class="product-thumbnail">
                                                <a href="#"><img src="assets/img/cart/cart-5.svg" alt=""></a>
                                            </td>
                                            <td class="product-name"><a href="#"> لورم ایپسوم </a></td>
                                            <td class="product-price-cart"><span class="amount">
                                                            40000
                                                            تومان
                                                        </span></td>
                                            <td class="product-quantity">
                                                2
                                            </td>
                                            <td class="product-subtotal">
                                                80000
                                                تومان
                                            </td>
                                        </tr>

                                        </tbody>
                                    </table>
                                </div>

                            </form>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal end -->

@endsection
