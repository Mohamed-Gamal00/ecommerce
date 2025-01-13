<?php

namespace App\Repositories\representatives_orders;

use App\Models\RepresentativesOrder;

class RepresentativesOrdersRepository implements RepresentativesOrdersInterface
{
  protected $representativesOrder;

  public function __construct(RepresentativesOrder $representativesOrder)
  {
    $this->representativesOrder = $representativesOrder;
  }

  public function getAll()
  {
    return $this->representativesOrder->all();
  }
  public function show($id)
  {
    return $this->representativesOrder->findOrFail($id);
  }

  public function store(array $data)
  {
    return $this->representativesOrder->create($data);
  }

  public function update(array $data, $id)
  {
    $order = $this->representativesOrder->findOrFail($id);
    $order->update($data);
    return $order;
  }

  public function delete($id)
  {
    $order = $this->representativesOrder->findOrFail($id);
    return $order->delete();
  }
}
