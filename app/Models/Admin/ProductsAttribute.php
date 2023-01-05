<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductsAttribute extends Model
{
    use HasFactory;
    protected $fillable = ['size', 'price', 'stock', 'sku', 'status', 'products_id'];
}
