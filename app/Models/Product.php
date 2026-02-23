<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    // Các trường có thể gán hàng loạt
    protected $fillable = [
        'category_id','name','slug','price','thumbnail','description','status'
    ];

    // Quan hệ n-1 với Category
    public function category() {
        return $this->belongsTo(Category::class);
    }

    // Quan hệ 1-n với ProductImage
    public function images() {
        return $this->hasMany(ProductImage::class);
    }
}
