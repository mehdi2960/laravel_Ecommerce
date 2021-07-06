<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductVariation extends Model
{
    use HasFactory,SoftDeletes;

    protected $table = "product_variations";
    protected $guarded = [];
    protected $appends = ['is_sale'];

    public function getIsSaleAttribute()
    {
        return ($this->sale_price != null && $this->date_on_sale_from < Carbon::now() && $this->date_on_sale_to > Carbon::now()) ? true : false;
    }
}
