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
}
