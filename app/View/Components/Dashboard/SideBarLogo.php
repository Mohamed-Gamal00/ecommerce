<?php

namespace App\View\Components\dashboard;

use App\Models\Setting;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class SideBarLogo extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        $settings = Setting::where('id', 1)->first();
        return view('components.dashboard.side-bar-logo', compact('settings'));
    }
}
