<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Color;
use App\Models\Order;
use App\Models\OrderStatus;
use App\Models\Product;
use App\Repositories\Order\ReturnOrderRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ReturnOrderController extends Controller
{
  protected $returnOrderRepository;

  public function __construct(ReturnOrderRepository $repo)
  {
    $this->returnOrderRepository = $repo;
  }

  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    //Gate::authorize('return_order.view');

    $orders = $this->returnOrderRepository->getAll();
    $defaultOrderStatus = OrderStatus::where('default_status', true)->first();
    return view('dashboard.return_order.index', \compact('orders'));
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
    //Gate::authorize('return_order.edit');

    $order = $this->returnOrderRepository->show($id);
    $category = Product::with('parent')->where('id', $order->products->first()->id)->get();
    $color = Color::where('id', $order->orderItems->first()->color)->first();
    $orderStatus = OrderStatus::all();

    return view('dashboard.return_order.show', compact('order', 'category', 'orderStatus', 'color'));
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
    //Gate::authorize('return_order.edit');

    $request->validate([
      'order_status_id' => 'required|exists:order_statuses,id'
    ]);

    $this->returnOrderRepository->update($request, $id);

    return \redirect()->route('return_orders.index')->with('success', 'تم تحديث حالة الطلب بنجاح');
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(string $id)
  {
    //Gate::authorize('return_order.delete');

    $this->returnOrderRepository->delete($id);

    return \redirect()->back()->with('dark', __('messages.RETURN_ORDER_DELETE'));
  }
}
