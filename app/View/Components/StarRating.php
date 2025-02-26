<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class StarRating extends Component
{
    public function __construct(public readonly ?float $rating)  //prende param $rating che puo essere float o null, che diventa un param pubblico dell'obj(lrv fa gia $this->rating = $rating;)!
    {

    }

    public function render(): View|Closure|string   //lrv passa AUTOMATICAMENTE tutte le proprieta pubbliche del componente alla vista Blade star-rating.blade.php
    {
        return view('components.star-rating');  //return la vista resouces/book/components/star-rating.blade.php
    }
}
