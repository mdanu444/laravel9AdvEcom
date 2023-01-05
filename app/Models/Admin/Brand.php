<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    use HasFactory;
    protected $fillable = ['title', 'status', 'products_id'];

    public function products(){
        return $this->hasMany(Product::class);
    }
}
