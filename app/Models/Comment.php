<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
    use HasFactory,SoftDeletes;

    protected $table = "comments";
    protected $guarded;

    public function getApprovedAttribute($approved)
    {
        return $approved ? 'تایید نشده' : 'تایید شده';
    }

    public function user()
    {
        return $this->belongsTo(User::class);

    }

    public function product()
    {
        return $this->belongsTo(Product::class);

    }
}
