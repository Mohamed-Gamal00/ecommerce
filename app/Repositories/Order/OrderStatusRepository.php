<?php

namespace App\Repositories\Order;

use App\Helper\Helper;
use App\Models\OrderStatus;

class OrderStatusRepository implements OrderStatusInterface
{
  use Helper;
  protected $orderStatus;

  public function __construct(OrderStatus $status)
  {
    $this->orderStatus = $status;
  }

  public function getAll()
  {
    return $this->orderStatus->orderBy('arrangement')->paginate();
  }

  public function getById($id)
  {
    return $this->orderStatus->findOrFail($id);
  }

  public function store($data)
  {
    return $this->orderStatus->create($data);
  }

  public function update($data, $id)
  {
    $orderStatus = $this->getById($id);
    $orderStatus->update($data);
    return $orderStatus->wasChanged();
  }

  public function delete($id)
  {
    $orderStatus = $this->getById($id);
    $orderStatus->delete();
  }

  public function getAllWithoutPagination()
  {
    return $this->orderStatus->all();
  }

  public function updateArrangement($statuses)
  {
    foreach ($statuses as $arrangement => $id) {
      $this->orderStatus->where('id', $id)->update(['arrangement' => $arrangement]);
    }
  }
}
