<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Color;
use App\Models\Order;
use App\Models\OrderStatus;
use App\Models\Product;
use App\Repositories\Order\OrderRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class OrderController extends Controller
{
    protected $orderRepository;

    public function __construct(OrderRepository $orderRepository)
    {
        $this->orderRepository = $orderRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //Gate::authorize('order.view');

        $orders = $this->orderRepository->getAll();
        $defaultOrderStatus = OrderStatus::where('default_status', true)->first();
        $user = Auth::guard('admin')->user();
        $notifications = $user->notifications()->where('type', "App\Notifications\OrderCreatedNotification")->get();

        return view('dashboard.orders.index', compact('orders', 'defaultOrderStatus', 'notifications'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //Gate::authorize('order.edit');
        $order = $this->orderRepository->show($id);
        // dd($order->user->addresses->first());
        $color = '';
        $orderStatus = OrderStatus::all();

        return view('dashboard.orders.show', compact('order', 'orderStatus', 'color'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //Gate::authorize('order.edit');

        $request->validate([
            'order_status_id' => 'required|exists:order_statuses,id'
        ]);

        $this->orderRepository->update($request, $id);

        return \redirect()->route('orders.index')->with('success', __('messages.ORDER_STATUS_UPDATED'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //Gate::authorize('order.delete');
        $this->orderRepository->delete($id);

        return \redirect()->back()->with('dark', __('messages.ORDER_DELETED'));
    }
}
