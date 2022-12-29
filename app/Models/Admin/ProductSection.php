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
        return $this->hasMany(ProductCategory::class, 'product_sections_id')->where('status', 1);
    }
    public function product_sub_categories()
    {
        return $this->hasMany(ProductSubCategory::class, 'product_sections_id', 'id')->where('status', 1);
    }
    public function products()
    {
        return $this->hasMany(Product::class, 'sections_id', 'id')->where('status', 1);
    }
}
