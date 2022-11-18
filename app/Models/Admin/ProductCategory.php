<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductCategory extends Model
{
    use HasFactory;
    protected $fillable =[
            'title',
            'discount',
            'description',
            'meta_title',
            'meta_description',
            'meta_keywords',
            'url',
            'image',
            'status',
            'product_sections_id',
    ];
    public function product_sections()
    {
        return $this->belongsTo(ProductSection::class);
    }
}
