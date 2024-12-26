<?php

namespace App\Models;
use Illuminate\Support\Facades\URL;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
   protected $fillable = ['image'];
   public function imageable()
   {
       return $this->morphTo();
   }
   public function url(): Attribute
   {
       return Attribute::make(fn(): string => URL::to('storage/' . $this->image));
   }
}
