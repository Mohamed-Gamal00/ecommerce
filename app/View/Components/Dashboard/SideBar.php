<?php

namespace App\View\Components\Dashboard;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\Component;

class SideBar extends Component
{
    /**
     * Create a new component instance.
     */
    public $unreadMessageCount;
    public $unreadOrderCreatedCount;
    public $unreadOrderReturnCount;

    public function __construct()
    {
        $user = Auth::guard('admin')->user();
        $this->unreadMessageCount = $user->unReadNotifications()
            ->where('type', 'App\Notifications\ContactFormSubmitted')
            ->count();
        $this->unreadOrderCreatedCount = $user->unReadNotifications()
            ->where('type', 'App\Notifications\OrderCreatedNotification')
            ->count();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.dashboard.side-bar');
    }
}
