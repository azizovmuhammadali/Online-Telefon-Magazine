<?php

namespace App\Models;
use App\Observers\CategoryObserver;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
#[ObservedBy(CategoryObserver::class)]
class Category extends Model
{
    protected $fillable = [
        "title",
        'slug',
    ];
    public function phones()
    {
        return $this->hasMany(Phone::class);
    }
    public function images()
    {
        return $this->morphMany(Image::class, 'imageable');
    }
}
