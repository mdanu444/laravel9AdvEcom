<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_sections_id', 'product_categories_id', 'product_sub_categories_id', 'brands_id', 'title', 'code', 'color', 'unit', 'weight', 'price', 'discount', 'featured', 'video', 'image', 'description', 'wash_care', 'fabric', 'pattern', 'sleeve', 'fit', 'occassion', 'meta_title', 'meta_keywords', 'meta_description', 'status'

    ];


    public function product_sections()
    {
        return $this->belongsTo(ProductSection::class);
    }


    public function product_categories()
    {
        return $this->belongsTo(ProductCategory::class);
    }


    public function product_sub_categories()
    {
        return $this->belongsTo(ProductSubCategory::class);
    }
    public function brands()
    {
        return $this->belongsTo(Brand::class);
    }
    public function products_attributes()
    {
        return $this->hasMany(ProductsAttribute::class, 'products_id');
    }
}
