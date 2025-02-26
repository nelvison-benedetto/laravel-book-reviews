@extends('layouts.app')

@section('content')
    <h1 class='mb-10 text-2x1'>Add Review for {{$book->title}}</h1>
    <form method='POST' action="{{route('books.reviews.store',$book)}}">
        {{--i.e. se book id=5 allora lrv genera url /books/5/reviews usando POST, eseguendo quindi method store() di ReviewController.php--}}
        @csrf
        <label for="review">Review</label>
        <textarea name="review" id="review" required class='input mb-4'></textarea>
        <label for="rating">Rating</label>
        <select name="rating" id="rating" class='input mb-4' required>
            <option value="">Select a Rating</option>
            @for($i=1;$i<=5;$i++)
                <option value="{{$i}}">{{$i}}</option>
            @endfor
        </select>
        <button type='submit' class='btn'>Add Review</button>
    </form>
@endsection
