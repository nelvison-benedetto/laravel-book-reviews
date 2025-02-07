<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;  //USE THIS!attention s '\Database\' !
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;
    public function reviews(){
        return $this->hasMany(Review::class);  //un book ha molte reviews
    }
    public function scopeTitle(Builder $query,string $title){
        return $query->where('title','LIKE','%'.$title.'%');
           //query before tested on Tinker (works as mongodb)
    }
}
