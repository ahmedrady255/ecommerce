<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class product extends Model
{
    use HasFactory, Sluggable;

    protected  $fillable =[
      'name',
      'description',
      'image',
      'price',
      'quantity',
      'category',
      'with_slider'
    ];

    public function images()
    {
        return $this->hasMany(Image::class);
    }
    public function sluggable():array
    {
        return
        [
            'slug'=>
            [
                'source'=>'name'
            ]
        ];
    }
    public function comments()
    {
      return  $this->hasMany(Comments::class);
    }

    public function category(){
        return $this->belongsTo(category::class);
    }
    public function stores(){
        return $this->belongsTo(stores::class);
    }
}
