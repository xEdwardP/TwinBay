<?php

namespace App\View\Components\ui\button;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class DeleteButton extends Component
{
    public $action;
    public $itemId;
    public $label;
    public $title;

    public function __construct($action, $itemId, $label = 'Eliminar', $title = 'Eliminar')
    {
        $this->action = $action;
        $this->itemId = $itemId;
        $this->label = $label;
        $this->title = $title;
    }

    public function render(): View|Closure|string
    {
        return view('components.ui.button.delete-button');
    }
}
