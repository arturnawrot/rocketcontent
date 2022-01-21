<?php

namespace App\View\Composers;

use Illuminate\View\View;

class ContentListingOptionsComposer
{
    /**
     * Bind data to the view.
     *
     * @param  \Illuminate\View\View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with('options', config('content.available_options'));
    }
}