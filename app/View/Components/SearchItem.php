<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class SearchItem extends Component
{
    public function __construct(public $records)
    {
        $this->records = $records;
    }

    public function render(): View
    {
        return view('messenger.components.search-item');
    }
}
