<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    // Các trường có thể gán hàng loạt
    protected $fillable = ['product_id','image_path'];

    // Quan hệ n-1 với Product
    public function product() {
        return $this->belongsTo(Product::class);
    }
}
