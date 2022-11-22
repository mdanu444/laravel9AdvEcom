<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductSection extends Model
{
    use HasFactory;
    protected $fillable = ['title'];

    public function product_categories()
    {
        return $this->hasMany(ProductCategory::class);
    }
    public function product_sub_categories()
    {
        return $this->hasMany(ProductSubCategory::class);
    }
    public function products(){
        return $this->hasMany(Product::class);
    }
}
