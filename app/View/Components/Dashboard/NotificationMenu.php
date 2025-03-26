<?php

namespace App\View\Components\Dashboard;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\Component;

class NotificationMenu extends Component
{
    public $notifications;
    public $newCount;

    /**
     * Create a new component instance.
     */
    public function __construct($count = 10)
    {
        $user = Auth::guard('admin')->user();
        $this->notifications = $user->unReadNotifications()->take($count)->get();

        $this->newCount = $user->unReadNotifications()->count();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.dashboard.notification-menu');
    }
}
