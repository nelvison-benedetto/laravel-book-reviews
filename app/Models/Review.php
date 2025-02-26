<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;  //x create reviews exapmples
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;
    protected $fillable=['review','rating'];  //remove protection MassAssignment, now you can use create() and update() with no limits
       //i.e. ora puoi creare nuova review semplicemnte con Review:create(['review'=>'Good book!', 'rating'=>5]);
    public function book(){
        return $this->belongsTo(related: Book::class);  //una review appartiene ad un solo book, in db column book_id is the connection
    }
    //i.e. $review=Review::find(1); $book=$review->book; echo $book->title;

    protected static function booted(){  //delete cache of book just updated or deleted or created, but lrv can still point to the old cache!
        static::updated(fn(Review $review)=>cache()->forget('book' . $review->book_id));
        static::deleted(fn(Review $review)=>cache()->forget('book' . $review->book_id));
        static::created(function(Review $review){
            cache()->forget('book' . $review->book_id);
            //dd('Cache aggiornata per il libro ID: ' . $review->book_id);  //x debug, see this only if cache updates!
        });
    }

    //puoi vedere l'applicazione dell'edit usando tinker
    //$review = \App\Models\Review::findOrFail(18);   //review id 18, book_id=2
    //$review -> rating = 4;
    //$review
    //$review->save();  //here also cache updates
    //i.e.
    //\App\Models\Review::where('id',18)->update(['rating'=>2]);
       //cache not updates because this run only a query without loading the model!
}
