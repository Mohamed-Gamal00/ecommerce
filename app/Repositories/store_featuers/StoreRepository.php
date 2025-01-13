<?php

namespace App\Repositories\store_featuers;

use App\Helper\Helper;
use App\Models\StoreFatuer;
use Illuminate\Support\Facades\Storage;

class StoreRepository implements StoreInterface
{
  use Helper;
  protected $featuer;

  public function __construct(StoreFatuer $featuer) // Corrected the model name
  {
    $this->featuer = $featuer;
  }

  public function getfeatuers()
  {
    return $this->featuer->paginate(); // Retrieve paginated list of features
  }

  public function store($data)
  {
    $data['image'] = $this->uploadedImage($data['request'], 'image', 'public');
    return $this->featuer->create($data); // Create a new feature
  }

  public function getById($id)
  {
    return $this->featuer->findOrFail($id); // Retrieve a specific feature by ID
  }

  public function update($id, $data)
  {
    $featuer = $this->getById($id);
    $oldImage = $featuer->image;

    if (isset($data['request'])) {
      $newImage = $this->uploadedImage($data['request'], 'image', 'public');
      if ($newImage) {
        $data['image'] = $newImage;
      }

      if ($newImage && $oldImage) {
        Storage::disk('public')->delete($oldImage);
      }
    }

    return $featuer->update($data); // Update the feature
  }

  public function delete($id)
  {
    $featuer = $this->getById($id);
    $oldImage = $featuer->image;

    if ($oldImage) {
      Storage::disk('public')->delete($oldImage);
    }

    return $featuer->delete(); // Delete the feature
  }
}
