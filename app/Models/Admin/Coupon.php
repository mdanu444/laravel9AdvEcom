<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory;

    public static function getStrToArr($string){
        $cagegoriesIdArray = explode(',', $string);
        return $cagegoriesIdArray;
    }
}
