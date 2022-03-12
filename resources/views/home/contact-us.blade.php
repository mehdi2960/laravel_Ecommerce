@extends('home.layouts.home')

@section('title')
    صفحه تماس با ما
@endsection

@section('style')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css"
          integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A=="
          crossorigin="" />
@endsection

@section('script')
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"
            integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA=="
            crossorigin="">
    </script>
    <script>
        var mymap = L.map('map').setView([{{ $setting->latitude }}, {{ $setting->longitude }}], 12);
        L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token={accessToken}', {
            attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
            maxZoom: 18,
            id: 'mapbox/streets-v11',
            tileSize: 512,
            zoomOffset: -1,
            accessToken: 'pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw'
        }).addTo(mymap);
        var marker = L.marker([{{ $setting->latitude }}, {{ $setting->longitude }}]).addTo(mymap);
        // marker.bindPopup("<b>Hello world!</b><br>I am a popup.").openPopup();
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
                    <li class="active">فروشگاه </li>
                </ul>
            </div>
        </div>
    </div>

    <div class="contact-area pt-100 pb-100">
        <div class="container">
            <div class="row text-right" style="direction: rtl;">
                <div class="col-lg-5 col-md-6">
                    <div class="contact-info-area">
                        <h2> لورم ایپسوم متن </h2>
                        <p>
                            لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است.
                        </p>
                        <div class="contact-info-wrap">
                            <div class="single-contact-info">
                                <div class="contact-info-icon">
                                    <i class="sli sli-location-pin"></i>
                                </div>
                                <div class="contact-info-content">
                                    <p> {{$setting->address}} </p>
                                </div>
                            </div>
                            <div class="single-contact-info">
                                <div class="contact-info-icon">
                                    <i class="sli sli-envelope"></i>
                                </div>
                                <div class="contact-info-content">
                                    <p>
                                        <a href="mailto:mehdiprogrammer30@gmail.com">mehdiprogrammer30@gmail.com</a>
                                    </p>
                                </div>
                            </div>
                            <div class="single-contact-info">
                                <div class="contact-info-icon">
                                    <i class="sli sli-screen-smartphone"></i>
                                </div>
                                <div class="contact-info-content">
                                    <p style="direction: ltr;"> {{$setting->telephone}}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-7 col-md-6">
                    <div class="contact-from contact-shadow">
                        <form id="contact-form" action="{{route('home.contact-us-form')}}" method="post">
                            @csrf
                            <input name="name" type="text" placeholder="نام شما">
                            @error('name')
                               <p class="input-error-validation">
                                   <strong>{{$message}}</strong>
                               </p>
                            @enderror
                            <input name="email" type="email" placeholder="ایمیل شما">
                            @error('email')
                            <p class="input-error-validation">
                                <strong>{{$message}}</strong>
                            </p>
                            @enderror
                            <input name="subject" type="text" placeholder="موضوع پیام">
                            @error('subject')
                            <p class="input-error-validation">
                                <strong>{{$message}}</strong>
                            </p>
                            @enderror
                            <textarea name="text" placeholder="متن پیام"></textarea>
                            @error('text')
                            <p class="input-error-validation">
                                <strong>{{$message}}</strong>
                            </p>
                            @enderror
                            <div id="contact_us_id"></div>
                            @error('g-recaptcha-response')
                            <p class="input-error-validation">
                                <strong>{{$message}}</strong>
                            </p>
                            @enderror

                            <button class="submit" type="submit"> ارسال پیام </button>
                        </form>
                        {!!  GoogleReCaptchaV3::render(['contact_us_id'=>'contact_us']) !!}
                    </div>
                </div>
            </div>
            <div class="contact-map pt-100">
                <div id="map"></div>
            </div>
        </div>
    </div>
@endsection
