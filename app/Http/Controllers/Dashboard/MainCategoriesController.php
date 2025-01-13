<?php

namespace App\Http\Controllers\Dashboard;

use App\Helper\Helper;
use App\Http\Controllers\Controller;
use App\Http\Requests\MainCategoryRequest;
use App\Models\Choice;
use App\Models\FirstSubCategory;
use App\Models\MainCategory;
use App\Models\MainCategoryMainCategorySetting;
use App\Models\MainCategorySetting;
use App\Models\SecSubCategory;
use App\Repositories\Category\CategoryRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

class MainCategoriesController extends Controller
{
  protected $categoryRepository;

  public function __construct(CategoryRepository $categoryRepository)
  {
    $this->categoryRepository = $categoryRepository;
  }

  use Helper;

  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    //Gate::authorize('category.view');

    $categories = $this->categoryRepository->getMainCategory();
    return view('dashboard.main_categories.index', compact('categories'));
  }

  /**
   * Show the form for creating a new resource.
   */
  public function create()
  {
    //Gate::authorize('category.create');
    $mainCategories = $this->categoryRepository->getMainCategory();
    $mainChoices = Choice::latest()->get();
    return view('dashboard.main_categories.create', compact('mainCategories', 'mainChoices'));
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(MainCategoryRequest $request)
  {
    //Gate::authorize('category.create');

    $data = $request->validated();
    // dd($data);
    // Common fields
    $data['image'] = $this->uploadedImage($request, 'image', 'main_categories');
    $data['slug'] = str_replace(' ', '-', $request->name);

    if ($request->input('type') == 'sub') {
      $validated = $request->validate([
        'parent_id' => ['required', 'exists:main_categories,id'],
      ]);
      $data['parent_id'] = $validated['parent_id'];
    } else {
      $data['parent_id'] = null;
    }
    // dd($data);

    $this->categoryRepository->store($data);

    return redirect()->route('main_categories.index')
      ->with('success', __('messages.MAIN_CATEGORY_CREATED'));
  }

  /**
   * Display the specified resource.
   */
  public function show(string $id) {}

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(string $id)
  {
    //Gate::authorize('category.edit');

    $category = $this->categoryRepository->getById($id);
    $mainCategories = $this->categoryRepository->getAllMainCategoriesExcept($id);

    $mainChoices = Choice::latest()->get();



    // $category = MainCategory::with('choices')->findOrFail($id);

    // $categoryChoices = $category->choices->pluck('id')->toArray();
    // $mainChoices = Choice::whereNotIn('id', $categoryChoices)->latest()->get();

    return view('dashboard.main_categories.edit', compact('category', 'mainCategories', 'mainChoices'));
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(MainCategoryRequest $request, $id)
  {
    //Gate::authorize('category.edit');
    $category = MainCategory::findOrFail($id);

    $data = $request->validated();

    // Common fields
    if ($request->hasFile('image')) {
      $data['image'] = $this->uploadedImage($request, 'image', 'main_categories');
    }
    $data['slug'] = str_replace(' ', '-', $request->name);

    if ($request->input('type') == 'sub') {
      $validated = $request->validate([
        'parent_id' => ['required', 'exists:main_categories,id'],
      ]);
      $data['parent_id'] = $validated['parent_id'];
    } else {
      $data['parent_id'] = null;
    }

    $this->categoryRepository->update($data, $id);

    return redirect()->route('main_categories.index')
      ->with('success', __('messages.MAIN_CATEGORY_UPDATED'));
  }

  /**
   * Remove the specified resource from storage.
   */
  // public function destroy(string $id)
  // {
  //   //Gate::authorize('category.delete');

  //   $this->categoryRepository->delete($id);

  //   return back()
  //     ->with('dark', 'تم حذف القسم بنجاح');
  // }

  public function destroy(string $id)
  {
    //Gate::authorize('category.delete');

    $this->categoryRepository->delete($id);

    return back();
    // ->with('dark', 'تم حذف القسم بنجاح');
  }
}
