<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderTtem extends Model
{
    use HasFactory;

    protected $table="order_items";
    protected $guarded=[];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
