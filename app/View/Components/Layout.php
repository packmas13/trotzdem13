<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Layout extends Component
{

    /**
     * navMain that should be selected
     */
    public string $navMain;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($navMain)
    {
        $this->navMain = $navMain;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.layout');
    }
}
