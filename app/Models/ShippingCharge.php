<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\District;

class ShippingCharge extends Model
{
    use HasFactory;

    protected $nullable = [];
    public function districts(){
        return $this->belongsTo(District::class, 'districts_id', 'id')->select('id', 'name');
    }
}
