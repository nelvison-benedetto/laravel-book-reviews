@extends('layouts.app')

 @section('content')   {{--riempie il contenuto di 'content' of app.blade.php --}}
    <h1 class='mb-10 text-2x1'>Books</h1>
    {{--form x search--}}
    <form method="GET" action="{{ route('books.index') }}" class='mb-4 flex items-center gap-2'>  {{--i dati verranno INVIATI a page index base with no filters--}}
        <input type="text" name="title" placeholder='Search by title'
            value='{{ request('title') }}' class='input h-10'   {{--se utente cerca ?title=Harry+Potter tramite questo form, dopo qua rimane scritto 'Harry Potter'--}}
        />
        <input type="hidden" name='filter' value='{{request('filter')}}'/>  {{--mantiene il filtro selezionato attivo anche dopo la ricerca--}}
        <button type='submit' class='btn h-10'>Search</button>
        <a href="{{ route('books.index') }}" class='btn h-10'>Clear</a>  {{--redirect to page index base with no filters--}}
    </form>

    <div class='filter-container mb-4 flex'>
        @php
            $filters = [   //array $key-$label (key-value)
                '' => 'Latest',
                'popular_last_month' => 'Popular Last Month',
                'popular_last_6month' => 'Popular Last 6 Monts',
                'highest_rated_last_month' => 'Highest Rated Last Month',
                'highest_rated_last_6month' => 'Highest Rated Last 6 Months',
            ];
        @endphp
        @foreach ($filters as $key=>$label)
                <a href="{{route('books.index',[...request()->query(),'filter'=>$key])}}"  {{-- aggiunge il filter con value=$key(ex $label) ai dati di request() gia esistenti nella query (i.e. title=Harry+Potter) --}}
                class='{{request('filter')===$key || (request('filter')===null && $key=== '') ? 'filter-item-active':'filter-item'}}'>  {{-- filter-item-active ha css con bordatura ed è colorato --}}
                {{$label}}
            </a>
        @endforeach
    </div>

    <ul>
        @forelse ($books as $book)   {{--$books proviene dal controller--}}
            <li class="mb-4">
                <div class="book-item">
                    <div class="flex flex-wrap items-center justify-between">
                        <div class="w-full flex-grow sm:w-auto">
                            <a href="{{route('books.show',$book)}}" class="book-title">{{$book->title}}</a>  {{--se clicchi vai a page resources/books/show.blade.php e passi come param il libro!--}}
                            <span class="book-author">by {{$book->author}}</span>
                        </div>
                        <div>
                            <div class="book-rating">
                                {{number_format($book->reviews_avg_rating, 1)}}  {{--prende il risult di reviews_avg_rating() e formattala solo con .X invece i.e. di .XX--}}
                                <x-star-rating :rating="$book->reviews_avg_rating"/>
                                    {{--USO DI COMPONENT, 'x-'(blade component) lrv capisce che deve eseguire StarRating.php(a cui viene passato il result di reviews_avg_rating come param chiamato 'rating')--}}
                                    {{--poi eseguire il costruttore e poi eseguire automaticamente render() (x eseguire star-rating.blade.php) --}}
                            </div>
                            <div class="book-review-count">
                                out of {{$book->reviews_count}} {{Str::plural('review',$book->reviews_count)}} {{--numtotreviews + review/reviews--}}
                                  {{--str::plural('basesingolarword', num(if >1,la basesingolarword diventa al plurale))--}}
                            </div>
                        </div>
                    </div>
                </div>
            </li>
        @empty  {{--se $books è vuoto...--}}
            <li class="mb-4">
                <div class="empty-book-item">
                    <p class="empty-text">No books found</p>
                    <a href="{{route('books.index')}}" class="reset-link">Reset criteria</a>
                </div>
            </li>
        @endforelse
    </ul>
@endsection
