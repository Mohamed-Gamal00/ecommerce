<?php

namespace App\Repositories\bulk_orders;

use App\Models\BulkOrder;

class BulkOrdersRepository implements BulkOrdersInterface
{
  protected $bulkOrder;

  public function __construct(BulkOrder $bulkOrder)
  {
    $this->bulkOrder = $bulkOrder;
  }

  public function getAll()
  {
    return $this->bulkOrder->all();
  }

  public function store(array $data)
  {
    return $this->bulkOrder->create($data);
  }

  public function update(array $data, $id)
  {
    $order = $this->bulkOrder->findOrFail($id);
    $order->update($data);
    return $order;
  }

  public function delete($id)
  {
    $order = $this->bulkOrder->findOrFail($id);
    return $order->delete();
  }
}
