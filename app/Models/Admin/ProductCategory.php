<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductCategory extends Model
{
    use HasFactory;
    protected $fillable =['title', 'product_sections_id'];
    public function product_sections()
    {
        return $this->belongsTo(ProductSection::class);
    }
}
