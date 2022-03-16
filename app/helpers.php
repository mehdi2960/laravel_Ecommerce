<?php

use App\Models\City;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\Province;
use Carbon\Carbon;

function generateFileName($name)
{
    $year = Carbon::now()->year;
    $month = Carbon::now()->month;
    $day = Carbon::now()->day;
    $hour = Carbon::now()->hour;
    $minute = Carbon::now()->minute;
    $second = Carbon::now()->second;
    $microsecond = Carbon::now()->microsecond;
    return $year . '_' . $month . '_' . $day . '_' . $hour . '_' . $minute . '_' . $second . '_' . $microsecond . '_' . $name;
}

function convertShamsiToGregorianDate($date)
{
    if ($date == null) {
        return null;
    }
    $pattern = "/[-\s]/";
    $shamsiDateSplit = preg_split($pattern, $date);

    $arrayGergorianDate = verta()->getGregorian($shamsiDateSplit[0], $shamsiDateSplit[1], $shamsiDateSplit[2]);

    return implode("-", $arrayGergorianDate) . " " . $shamsiDateSplit[3];
}

function cartTotalSaleAmount()
{
    $cartTotalSaleAmount = 0;
    foreach (\Cart::getContent() as $item) {
        if ($item->attributes->is_sale) {
            $cartTotalSaleAmount += $item->quantity * ($item->attributes->price - $item->attributes->sale_price);
        }
    }
    return $cartTotalSaleAmount;
}

//هزینه ارسال
function cartTotalDeliveryAmount()
{
    $cartTotalDeliveryAmount = 0;
    foreach (\Cart::getContent() as $item) {
        $cartTotalDeliveryAmount += $item->associatedModel->delivery_amount;
    }

    return $cartTotalDeliveryAmount;
}

// چک کردن کد تخفیف
function checkCoupon($code)
{
    $coupon = Coupon::where('code', $code)->where('expired_at', '>', Carbon::now())->first();

    if ($coupon == null) {
        session()->forget('coupon'); // پاک کردن کد تخفیف
        return ['error' => 'کد تخفیف وارد شده وجود ندارد'];
    }

    // کد تخفیف استفاده کرده است یا نه
    if (Order::where('user_id', auth()->id())->where('coupon_id', $coupon->code)->where('payment_status', 1)->exists()) {
        session()->forget('coupon'); // پاک کردن کد تخفیف
        return ['error' => 'شما قبلا از این کد تخفیف استفاده کرده اید'];
    }

    // چک کردن کوپن تخفیف درصدی یا مبلغی
    if ($coupon->getRawOriginal('type') == 'amount') {
        session()->put('coupon', ['id' => $coupon->id, 'code' => $coupon->code, 'amount' => $coupon->amount]);
    } else {
        $total = \Cart::getTotal(); // قیمت کل

        $amount = (($total * $coupon->percentage) / 100) > $coupon->max_percentage_amount ? $coupon->max_percentage_amount : (($total * $coupon->percentage) / 100);

        session()->put('coupon', ['id' => $coupon->id, 'code' => $coupon->code, 'amount' => $amount]);
    }

    return ['success' => 'کد تخفیف برای شما ثبت شد'];
}


function province_name($provinceId)
{
    return Province::findOrFail($provinceId)->name;
}

function city_name($cityId)
{
    return City::findOrFail($cityId)->name;
}

?>
