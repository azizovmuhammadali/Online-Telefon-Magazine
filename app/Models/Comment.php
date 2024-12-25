<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = [
        'comment',
        'phone_id',
        'user_id',
    ] ;
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function phones(){
        return $this->hasMany(Phone::class);
    }
}
