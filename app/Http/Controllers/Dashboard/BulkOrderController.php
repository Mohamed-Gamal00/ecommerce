<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Repositories\bulk_orders\BulkOrdersRepository;
use Illuminate\Http\Request;

class BulkOrderController extends Controller
{
  protected $bulkOrders;

  public function __construct(BulkOrdersRepository $bulkOrders)
  {
    $this->bulkOrders = $bulkOrders;
  }
  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    $orders = $this->bulkOrders->getAll();
    return view('dashboard.bulk_orders.index', compact('orders'));
  }

  /**
   * Show the form for creating a new resource.
   */
  public function create()
  {
    return view('dashboard.bulk_orders.create');
  }

  /**
   * Display the specified resource.
   */
  public function show(string $id)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit($id)
  {
    $order = $this->bulkOrders->getAll()->find($id);
    return view('dashboard.bulk_orders.edit', compact('order'));
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, $id)
  {
    $request->validate([
      'name' => 'required|string|max:255',
      'phone' => 'required|string|max:255',
      'company_name' => 'required|string|max:255',
      'description' => 'required|string',
    ]);

    $this->bulkOrders->update($request->all(), $id);

    return redirect()->route('bulk_orders.index')
    ->with('success', __('messages.BULKORDER_UPDATED'));
  }
  /**
   * Remove the specified resource from storage.
   */
  public function destroy($id)
  {
    $this->bulkOrders->delete($id);

    return redirect()->route('bulk_orders.index')
    ->with('success', __('messages.BULKORDER_DELETED'));
  }
}
