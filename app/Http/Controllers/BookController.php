<?php

namespace App\Http\Controllers;
use App\Models\Book;
use Illuminate\Container\Attributes\Cache;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache as FacadesCache;

class BookController extends Controller
{

    public function index(Request $request)
    {
          //i.e. con richiesta http /books?title=Harry Potter
        $title = $request->input('title');  //get the title from the request
        $filter = $request->input('filter','');  //get the filter from the request,
        $books = Book::when(
            $title,   //se $title != null allora run anonymous funct
        fn($query, $title)=>$query->title($title)  //$query è un'istanza di Illuminate\Database\Eloquent\Builder rappresenta la query non ancora eseguita,
                    //lrv chiama scope locale scopeTitle()(lo trovi in Book.php), '$query->' xk lo scopeTitle() deve essere eseguito su un obj query
        );
        $books = match($filter){  //se $filter == 'popular_last_month' allora run popularLastMonth(), ect
            'popular_last_month' => $books->popularLastMonth(),
            'popular_last_6month' => $books->popularLast6Month(),
            'highest_rated_last_month' => $books->highestRatedLastMonth(),
            'highest_rated_last_6month' => $books->highestRatedLast6Month(),
            default => $books->latest()->withAvgRating()->withReviewsCount(),
        };
        //$books = $books->get();

        $cacheKey = 'books:' .$filter . ':' . $title;  //creates unique key
        $books =
            //cache()->remember(  //al posto di cache() possibile anche FacadesCache::remember(...)
           // $cacheKey,
           // 3600,  //+-1ora
           // fn() =>
            $books->get();
        //);
        return view('books.index',['books'=>$books]);  //pass the results to resources/views/books/index.blade.php
    }   //now go to resources/view/books/index.blade.php  and views/layouts/app.blade.php

    public function create()
    {
    }
    public function store(Request $request)
    {
    }

    // public function show(Book $book)  //basic version, execute 2 queries instead of only 1 and it's not customizable with withAvgRating() or withReviewsCount()
    // {
    //     $cacheKey = 'book:'.$book->id;
    //     $book = cache()->remember(
    //         $cacheKey,
    //         3600,
    //         fn() => $book->load([    //load() x fething relations x model that is aready loaded!
    //             'reviews' => fn($query)=>$query->latest()
    //         ])
    //     );
    //     return view(
    //  'books.show',['book'=>$book]);
    // }
    public function show(int $id)
    {
        $cacheKey = 'book:'.$id;   //creates unique key
        $book = cache()->remember(  //se il libro con questa cacheKey ESISTE GIA nella cache, lo recupera senza interrogare il DB!!
            $cacheKey,
            3600,
            fn() => Book::with([
                'reviews' => fn($query)=>$query->latest()
            ]) -> withAvgRating()->withReviewsCount()->findOrFail($id)
        );
        return view(
     'books.show',['book'=>$book]);  //pass the result to resources/views/books/show.blade.php
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
