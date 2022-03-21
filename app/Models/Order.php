<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $table="orders";
    protected $guarded=[];

    public function getStatusAttribute($status)
    {
       switch ($status)
       {
           case '0':
               $status= 'در انتظار پرداخت';
               break;
           case '1':
               $status= 'پرداخت شده';
               break;
       }
       return $status;
    }

    public function getPaymentTypeAttribute($paymentType)
    {
       switch ($paymentType)
       {
           case 'pos':
               $paymentType= 'دستگاه pos';
               break;
           case 'online':
               $paymentType= 'اینترنتی';
               break;
       }
       return $paymentType;
    }
    public function getPaymentStatusAttribute($paymentStatus)
    {
       switch ($paymentStatus)
       {
           case '0':
               $paymentStatus= 'ناموفق';
               break;
           case '1':
               $paymentStatus= 'موفق';
               break;
       }
       return $paymentStatus;
    }

    public function orderItems()
    {
        return $this->hasMany(OrderTtem::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function copoun()
    {
        return $this->belongsTo(Coupon::class);
    }

    public function address()
    {
        return $this->belongsTo(UserAddress::class);
    }
}
