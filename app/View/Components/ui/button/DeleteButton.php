<?php

namespace App\View\Components\ui\button;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class DeleteButton extends Component
{
    public $action;
    public $itemId;

    public function __construct($action, $itemId)
    {
        $this->action = $action;
        $this->itemId = $itemId;
    }

    public function render(): View|Closure|string
    {
        return view('components.ui.button.delete-button');
    }
}
