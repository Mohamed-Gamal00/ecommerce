<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\RepresentativesOrder;
use App\Repositories\representatives_orders\RepresentativesOrdersRepository;
use Illuminate\Http\Request;

class RepresentativesOrderController extends Controller
{
  protected $representativesOrders;

  public function __construct(RepresentativesOrdersRepository $representativesOrders)
  {
    $this->representativesOrders = $representativesOrders;
  }

  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    $orders = $this->representativesOrders->getAll();
    return view('dashboard.representatives_orders.index', compact('orders'));
  }

  /**
   * Show the form for creating a new resource.
   */
  public function create()
  {
    return view('dashboard.representatives_orders.create');
  }

  /**
   * Store a newly created resource in storage.
   */
  // public function store(Request $request)
  // {
  //   $request->validate([
  //     'name' => 'required|string|max:255',
  //     'phone' => 'required|string|max:255',
  //     'description' => 'required|string',
  //   ]);

  //   $this->representativesOrders->store($request->all());

  //   return redirect()->route('representatives_orders.index')
  //   ->with('success', 'Order created successfully.');
  // }

  /**
   * Display the specified resource.
   */
  // public function show(string $id)
  // {
  //   $data = $this->representativesOrders->show($id);
  //   return view('dashboard.representatives_orders.index', compact('data'));
  // }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit($id)
  {
    $order = $this->representativesOrders->getAll()->find($id);
    return view('dashboard.representatives_orders.edit', compact('order'));
  }



  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, $id)
  {
    $request->validate([
      'name' => 'required|string|max:255',
      'phone' => 'required|string|max:255',
      'description' => 'required|string',
    ]);

    $this->representativesOrders->update($request->all(), $id);

    return redirect()->route('representatives_orders.index')
    ->with('success', 'Order updated successfully.');
  }

  /**
   * Remove the specified resource from storage.
   */
  // public function destroy($id)
  // {
  //   $this->representativesOrders->delete($id);

  //   return redirect()->route('representatives_orders.index')
  //   ->with('success', 'Order deleted successfully.');
  // }
}
