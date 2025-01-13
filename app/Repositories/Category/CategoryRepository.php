<?php

namespace App\Repositories\Category;

use App\Helper\Helper;
use App\Models\MainCategory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class CategoryRepository implements CategoryInterface
{
  use Helper;

  protected $category;

  public function __construct(MainCategory $category)
  {
    $this->category = $category;
  }

  public function getMainCategory()
  {
    return $this->category->latest()->paginate();
  }

  public function getAllMainCategoriesExcept($id)
  {
    return $this->category->where('id', '!=', $id)->get();
  }

  public function getById($id)
  {
    return $this->category->findOrFail($id);
  }

  public function store($data)
  {
    DB::transaction(function () use ($data) {
      $category = $this->category->create($data);

      if (request()->has('category')) {
        $category->settings()->sync(request()->input('category'));
      }

      if (request()->has('choice_id')) {
        $category->choices()->attach(request()->input('choice_id'));
      }
    });
  }

  public function update($data, $id)
  {
    $category = $this->getById($id);

    DB::transaction(function () use ($category, $data) {
      $category->update($data);

      if (request()->has('category')) {
        $category->settings()->sync(request()->input('category'));
      }
      if (request()->has('choice_id')) {
        // dd($data);
        $category->choices()->sync(request()->input('choice_id'));
      }
      // $category->choices()->sync(request()->post('choice_id'));
    });
  }

  // public function delete($id)
  // {
  //   $category = $this->category->with('products')->findOrFail($id);
  //   if ($category->products->first()) {
  //     return redirect()->route('main_categories.index')
  //     ->with('danger', 'القسم يوجد به منتجات لا يمكنك حذفه');
  //   }
  //   $category->delete();
  // }



  private function hasProducts($category)
  {
    // Check if the category has products
    if ($category->products->isNotEmpty()) {
      return true;
    }

    // Recursively check each child category
    foreach ($category->children as $child) {
      if ($this->hasProducts($child)) {
        return true;
      }
    }

    return false;
  }


  public function delete($id)
  {
    $category = $this->category->with('children', 'products')->findOrFail($id);

    if ($this->hasProducts($category)) {
      return redirect()->route('main_categories.index')
        ->with('danger', 'القسم أو أحد الأقسام الفرعية يوجد به منتجات لا يمكنك حذفه');
    }

    $category->delete();
    return redirect()->route('main_categories.index')
      ->with('danger', __('messages.MAIN_CATEGORY_DELETED'));
  }
}
