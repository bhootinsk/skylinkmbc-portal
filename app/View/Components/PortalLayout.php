<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class PortalLayout extends Component
{
    public function __construct(public ?string $area = null) {}

    public function render(): View|Closure|string
    {
        return view('layouts.portal');
    }
}
