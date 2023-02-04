<?php

namespace App\Models;

use App\Models\Admin\ShippingAddresses;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    public function order_items(){
        return $this->hasMany(OrderItem::class, 'order_id', 'id')->with('product');
    }

    public function shipping(){
        return $this->belongsTo(ShippingAddresses::class,'shipping_address', 'id')->with('districts', 'divisions', 'upazilas');
    }

    public function users(){
        return $this->belongsTo(User::class, 'user_id');
    }
}
