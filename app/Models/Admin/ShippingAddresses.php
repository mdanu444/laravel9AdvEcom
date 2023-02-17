<?php

namespace App\Models\Admin;

use App\Models\District;
use App\Models\Division;
use App\Models\Order;
use App\Models\ShippingCharge;
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
    public function orders(){
        return $this->hasOne(Order::class);
    }
    public static function getShippingCharge($weight, $district){
        $shipping = ShippingCharge::where('districts_id', $district)->first();
        if(($weight > 0) && ($weight < 501)){
            $shipping_charge =  $shipping->weight_0_500g;
        }
        if(($weight > 500) && ($weight < 1001)){
            $shipping_charge =  $shipping->weight_501_1000g;
        }
        if(($weight > 1000) && ($weight < 2001)){
            $shipping_charge =  $shipping->weight_1001_2000g;
        }
        if(($weight > 2000) && ($weight < 5001)){
            $shipping_charge =  $shipping->weight_2001_5000g;
        }
        if($weight > 5000){
            $shipping_charge =  $shipping->weight_5001g_above;
        }
        return $shipping_charge;
    }

}
