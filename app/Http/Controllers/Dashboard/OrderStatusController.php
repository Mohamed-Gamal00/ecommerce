<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\OrderStatus;
use App\Repositories\Order\OrderStatusRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class OrderStatusController extends Controller
{

  protected $orderStatusRepository;

  public function __construct(OrderStatusRepository $repo)
  {
    $this->orderStatusRepository = $repo;
  }


  public function index()
  {
    //Gate::authorize('order_status.view');

    $orderStatus = $this->orderStatusRepository->getAll();
    return view('dashboard.order_status.index', [
      'orderStatus' => $orderStatus,
    ]);
  }

  /**
   * Show the form for creating a new resource.
   */
  public function create()
  {
    //Gate::authorize('order_status.create');

    return view('dashboard.order_status.create');
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(Request $request)
  {
    //Gate::authorize('order_status.create');

    $data = $request->validate([
      'name' => 'required|string|max:255',
      'name_en' => 'nullable|string|max:255'
    ]);
    $this->orderStatusRepository->store($data);

    return to_route('order_status.index')
      ->with('success', __('messages.ORDER_STATUS_CREATED'));
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
  public function edit(string $id)
  {
    //Gate::authorize('order_status.edit');

    $orderStatus = $this->orderStatusRepository->getById($id);
    return view('dashboard.order_status.edit', \compact('orderStatus'));
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, string $id)
  {
    //Gate::authorize('order_status.edit');

    $data = $request->validate([
      'name' => 'required|string|max:255',
      'name_en' => 'nullable|string|max:255',
    ]);

    $orderStatus = $this->orderStatusRepository->update($data, $id);

    if ($orderStatus) {
      return to_route('order_status.index')
        ->with('success', __('messages.ORDER_STATUS_UPDATED'));
    }

    return to_route('order_status.index')
      ->with('info', 'لم يتم التعديل لعدم وجوود أي تغيير');
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(string $id)
  {
    //Gate::authorize('order_status.delete');

    $this->orderStatusRepository->delete($id);
    return to_route('order_status.index')
      ->with('danger', __('messages.ORDER_STATUS_DELETED'));
  }

  public function orderArrangement()
  {
    //Gate::authorize('order_status.create');

    $orderStatus = $this->orderStatusRepository->getAllWithoutPagination();
    $counter = 1;
    return view('dashboard.order_status.order_arrangement', compact('orderStatus', 'counter'));
  }

  public function orderArrangementUpdate(Request $request)
  {
    //Gate::authorize('order_status.create');

    $statusId = array_values($request->statuses_id);
    $findDuplicate = array_diff_assoc($statusId, array_unique($statusId));
    if (!empty($findDuplicate)) {
      return \redirect()->back()->with('danger', __('messages.ORDER_STATUS_REPEAT'));
    }

    $this->orderStatusRepository->updateArrangement($request->statuses_id);

    return \redirect()->back()->with('success', __('messages.ORDER_STATUS_UPDATED'));
  }
}
