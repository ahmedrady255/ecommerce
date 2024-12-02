<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class stores extends Model
{
    use HasFactory;
    protected $table = 'stores';
     protected $fillable=[
         "name",
         "icon",
         "description",
         "phone",
         "email",
         "categories"
     ];
     public function products(){
         return $this->hasMany(product::class);
     }
     public function categories(){
         return $this->hasMany(category::class);
     }
}

