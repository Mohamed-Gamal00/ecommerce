<?php

namespace App\Repositories\Advertisement;

use App\Models\Advertisement;
use Illuminate\Support\Facades\Storage;

class AdvertisementRepository implements AdvertisementInterface
{
  protected $advertisement;

  public function __construct(Advertisement $advertisement)
  {
    $this->advertisement = $advertisement;
  }

  public function getMainAdvertisemnt()
  {
    return $this->advertisement->all();
  }

  public function store($data)
  {
    return $this->advertisement->create($data);
  }

  public function update($data, $id)
  {
    $advertisement = $this->advertisement->findOrFail($id);
    $advertisement->update($data);
    return $advertisement;
  }

  public function delete($id)
  {
    $advertisement = $this->advertisement->findOrFail($id);
    $advertisement->delete();
    return $advertisement;
  }
}
