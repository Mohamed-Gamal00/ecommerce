<?php

namespace App\Repositories\Order;

use App\Helper\Helper;
use App\Models\Order;

class ReturnOrderRepository implements ReturnOrderInterface
{
  use Helper;
  protected $order;

  public function __construct(Order $order)
  {
    $this->order = $order;
  }

  public function getAll()
  {
    return $this->order->latest()
      ->with('user', 'addresses', 'addresses.country', 'addresses.city', 'orderItems', 'orderStatus')
      ->where('return_order', true)
      ->filter(request()->input('order_number'))
      ->paginate();
  }

  public function show($id)
  {
    return $this->order->with('user', 'addresses', 'addresses.country', 'addresses.city', 'orderItems')
    ->findOrFail($id);
  }

  public function update($request, $id)
  {
    $order = $this->order->findOrFail($id);
    $order->update([
      'order_status_id' => $request->order_status_id
    ]);

    return $order;
  }

  public function delete($id)
  {
    $order = $this->order->findOrFail($id);
    $order->delete();

    return $order;
  }
}
