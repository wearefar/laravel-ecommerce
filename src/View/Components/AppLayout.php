<?php

namespace WeAreFar\Ecommerce\View\Components;

use Illuminate\View\Component;

class AppLayout extends Component
{
    public $title;

    public function __construct($title = null)
    {
        $this->title = $title ?
            $title.' - '.config('app.name') :
            config('app.name');
    }

    /**
     * Get the view / contents that represents the component.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view('ecommerce::layouts.app');
    }
}
