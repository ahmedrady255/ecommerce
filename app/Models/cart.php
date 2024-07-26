<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class cart extends Model
{
    use HasFactory;
    protected $fillable = [
        'product_id',
        'user_id',
        'quantity'
    ];
    public function User()
    {
        return $this->hasOne('App\Models\User', 'id', 'user_id');
    }
    public function Product()
    {
        return $this->hasOne('App\Models\Product', 'id', 'product_id');
    }
}
