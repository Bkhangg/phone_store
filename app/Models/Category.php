<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['name','slug','status'];

    // Quan hệ 1-n với Product
    public function products() {
        return $this->hasMany(Product::class);
    }
}
