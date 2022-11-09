<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Admin\ProductCategory;
use App\Models\Admin\ProductSection;

class ProductSubCategory extends Model
{
    use HasFactory;
    protected $fillable =['title', 'product_sections_id', 'product_categories_id'];

    public function product_sections()
    {
        return $this->belongsTo(ProductSection::class);
    }

    public function product_categories()
    {
        return $this->belongsTo(ProductCategory::class);
    }
}
