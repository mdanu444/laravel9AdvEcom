<?php

namespace App\Models\Admin;

use App\Models\District;
use App\Models\Division;
use App\Models\Upazila;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShippingAddresses extends Model
{
    use HasFactory;

    public $fillable = ['name', 'address', 'mobile', 'divisions_id', 'districts_id', 'upazilas_id'];

    public function divisions(){
        return $this->belongsTo(Division::class)->select('id', 'name');
    }
    public function districts(){
        return $this->belongsTo(District::class)->select('id', 'name');
    }
    public function upazilas(){
        return $this->belongsTo(Upazila::class)->select('id', 'name');
    }
}
