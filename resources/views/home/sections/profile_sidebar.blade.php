<div class="myaccount-tab-menu nav" role="tablist">

    <a href="{{route('home.users_profile.index')}}" class="{{request()->is('profile') ? 'active':''}}">
        <i class="sli sli-user ml-1"></i>
        پروفایل
    </a>

    <a href="#orders" data-toggle="tab">
        <i class="sli sli-basket ml-1"></i>
        سفارشات
    </a>

    <a href="#address" data-toggle="tab">
        <i class="sli sli-map ml-1"></i>
        آدرس ها
    </a>

    <a href="{{route('home.wishlist.users_profile.index')}}" class="{{request()->is('profile/wishlist') ?'active':''}}">
        <i class="sli sli-heart ml-1"></i>
        لیست علاقه مندی ها
    </a>

    <a href="{{route('home.comments.users_profile.index')}}" class="{{request()->is('profile/comments') ?'active':''}}">
        <i class="sli sli-bubble ml-1"></i>
        نظرات
    </a>

    <a href="login.html">
        <i class="sli sli-logout ml-1"></i>
        خروج
    </a>

</div>
