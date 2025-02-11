<?php

declare(strict_types=1);

namespace App\Livewire\Layout;

use Illuminate\View\View;
use Livewire\Component;

final class AppNavigation extends Component
{
    public function render(): View
    {
        return view('livewire.layout.app-navigation');
    }
}
