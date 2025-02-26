<?php

namespace App\Http\Controllers;
use App\Models\Book;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    // public function __construct(){  //rate limiting(lesson 56) edit also file RouteServiceProvider.php
    //     $this->middleware('throttle:reviews')->only(['store']);
    // }

    public function index()
    {
    }
    public function create(Book $book)  //x chi vuole usare create() per creare una nuova review, invece viene teletrasportato sul form della pagina web x creare una nuova review
    {   //lrv use Route Model Binding, quindi $book è gia un'istanza di Book
        return view('books.reviews.create',['book' => $book]);  //pass the result to resources/views/books/reviews/create.blade.php
        //i.e. if user search /books/5/reviews/create lrv find book with id=5 and pass the book to create.blade.php
    }

    public function store(Request $request, Book $book)
    {
        $data = $request->validate([
            'review' => 'required|min:15',  //field deve essere esistente e con 15> chars
            'rating' => 'required|min:1|max:5|integer'  //filed deve essere esistente ect ect
        ]);
        $book->reviews()->create($data);   //la funzione qua sopra create(Book $book) non c'entra niente
          //use method reviews() of Book.php and return una istanza di hasMany, lrv sa che deve aggiungere field book_id nella review
          //crete($data) create a new row nella tablle db reviews, with the data $data
        cache()->forget('book:' . $book->id);  //PULISCE LA CACHE altrimenti lrv puo puntare ancora alla vecchia cache(quella not updated)!
        return redirect()->route('books.show',$book);  //redirect to web page of the book (ora vedi anche la review appena aggiunta!)
    }

    public function show(string $id)
    {
    }
    public function edit(string $id)
    {
    }
    public function update(Request $request, string $id)
    {
    }
    public function destroy(string $id)
    {
    }
}
