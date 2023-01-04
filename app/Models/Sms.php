<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sms extends Model
{
    use HasFactory;

    public static function sendmessage($mobile, $message){
        // apikey = oyiiHu8Hy95LqCjbXZqn23Y5EBDoh2hs9CbOXV32

    $curl = curl_init();

    curl_setopt_array($curl, array(
    CURLOPT_URL => 'https://api.sms.net.bd/sendsms',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_CUSTOMREQUEST => 'POST',
    CURLOPT_POSTFIELDS => array('api_key' => 'oyiiHu8Hy95LqCjbXZqn23Y5EBDoh2hs9CbOXV32','msg' => $message,'to' => '88'.$mobile),
    ));
    $response = curl_exec($curl);
    curl_close($curl);
    return $response;
    }
}
