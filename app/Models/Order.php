<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Order extends Model
{
    use HasFactory;
    protected $fillable = ['status','payment_status','order_items','sub_total'];
    public function user(){
        return $this->hasOne(User::class,'id','user_id');
    }

}
