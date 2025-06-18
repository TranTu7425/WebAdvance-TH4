<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Coupon extends Model
{
    use HasFactory;

    protected $fillable = ['code', 'discount', 'status', 'product_id'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
