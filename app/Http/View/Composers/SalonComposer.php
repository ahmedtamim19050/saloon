<?php

namespace App\Http\View\Composers;

use Illuminate\View\View;

class SalonComposer
{
    public function compose(View $view): void
    {
        // Check if user is authenticated and has a salon
        if (auth()->check() && auth()->user()->salon) {
            $view->with('salon', auth()->user()->salon);
        }
    }
}
