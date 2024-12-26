<?php

namespace App\Models;

use App\Observers\CategoryObserver;
use Illuminate\Support\Facades\URL;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
#[ObservedBy(CategoryObserver::class)]
class Category extends Model
{
    protected $fillable = [
        "title",
        'image',
        'slug',
    ];
    public function phones()
    {
        return $this->hasMany(Phone::class);
    }
    public function url(): Attribute
    {
        return Attribute::make(fn(): string => URL::to('storage/' . $this->image));
    }
}
