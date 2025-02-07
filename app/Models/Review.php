<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;
    protected $fillable=['review','rating'];
    public function book(){
        return $this->belongsTo(related: Book::class);  //una review appartiene ad un book, column book_id nelle migrations folder
    }
}
