<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Model;
#[ObservedBy(Phone::class)]
class Phone extends Model
{
    protected $fillable = [
        "name","model","user_id","category_id",'slug','price',    ];
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function category(){
        return $this->belongsTo(Category::class);
    }
    public function comments(){
        return $this->hasMany(Comment::class);
    }
    public function images()
    {
        return $this->morphMany(Image::class, 'imageable');
    }
}
