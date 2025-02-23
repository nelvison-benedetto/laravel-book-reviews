<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;  //it's different than \Query\Builder;
use Illuminate\Database\Eloquent\Builder;  //USE THIS!(it's different than '/Query/Builder;') attention '\Database\' !
use Illuminate\Database\Query\Builder as QueryBuilder;  //use alias to avoid name conflicts!

class Book extends Model
{
    use HasFactory;
    public function reviews(){
        return $this->hasMany(Review::class);  //un book ha molte reviews
    }
    public function scopeTitle(Builder $query,string $title){  //x easy filter searching with '\App\Models\Book::title('delectus')->get();'
        return $query->where('title','LIKE','%'.$title.'%');
           //query before tested on Tinker (works as mongodb)
    }

    //basic scopes functs
    // public function scopePopular(Builder $query):Builder{
    //     return $query->withCount('reviews')->orderBy('reviews_count','desc');
    // }
    // public function scopeHighestRated(Builder $query):Builder{
    //     return $query->withAvg('reviews','rating')->orderBy('reviews_avg_rating','desc');
    // }

    public function scopePopular(Builder $query, $from=null, $to=null):Builder|QueryBuilder {
        return $query->withCount([
            'reviews'=> fn(Builder $q) => $this->dateRangeFilter($q,$from,$to)
        ])
            ->orderBy('reviews_count','desc');
    }
    public function scopeHighestRated(Builder $query, $from=null, $to=null):Builder|QueryBuilder {
        return $query->withAvg(
            ['reviews'=> fn(Builder $q) => $this->dateRangeFilter($q,$from,$to)]
            ,'rating')
            ->orderBy('reviews_avg_rating','desc');
    }

    public function scopeMinReviews(Builder $query, int $minReviews):Builder|QueryBuilder{
        return $query->having('reviews_count','>=',$minReviews);
    }

    private function dateRangeFilter(Builder $query, $from=null, $to=null){
            if($from && !$to){  $query->where('created_at','>=',$from);  }
            elseif(!$from && $to){  $query->where('created_at', '<=', $to); }
            elseif($from && $to){  $query->whereBetween('created_at',[$from,$to]);}
    }
}
