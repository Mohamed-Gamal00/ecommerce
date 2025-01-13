<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\MainCategory;
use App\Models\MainCategorySetting;
use App\Models\SubSettings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class MainCategoriesSettingsController extends Controller
{
  public $categoryId;

  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    //Gate::authorize('filter.view');

    $settings = MainCategorySetting::latest()->paginate(10);

    return view('dashboard.filters.index', compact('settings'));
  }

  /**
   * Show the form for creating a new resource.
   */
  public function create()
  {
    //
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(Request $request)
  {
    //Gate::authorize('filter.create');

    $data = $request->validate([
      'name' => 'required|string|min:3|max:30'
    ]);


    if (MainCategorySetting::where('name', request()->input('name'))->count()) {
      return redirect()->back()
        ->with('danger', 'التصنيف موجود بالفعل');
    }

    MainCategorySetting::create($data);
    return redirect()->back()->with('success', 'تم إنشاء التصنيف بنجاح');
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
    //Gate::authorize('filter.edit');

    $filter = MainCategorySetting::findOrFail($id);
    return view('dashboard.filters.edit_main_filter', compact('filter'));
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, string $id)
  {
    //Gate::authorize('filter.edit');

    $data = $request->validate([
      'name' => 'required|max:255'
    ]);


    $filter = MainCategorySetting::findOrFail($id);
    $filter->update($data);

    if ($filter->wasChanged('name')) {
      return redirect()->route('filters.index')->with('success', 'تم تعديل التصنيف بنجاح');
    }

    return redirect()->back()->with('dark', 'لم يتم تحديث العنصر لعدم وجود أي تغيير');
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(string $id)
  {
    //Gate::authorize('filter.delete');

    $setting = MainCategorySetting::with('categories')->findOrFail($id);

    $data = [];
    foreach ($setting->categories as $filter) {
      $data[] = $filter->name;
    }

    if ($data) {
      return redirect()->back()->with('danger', 'التصنيف يوجد به منتجات');
    }

    if ($setting->subSettings->first()) {
      return redirect()->back()->with('danger', 'التصنيف يوجد به تصنيفات فرعيه');
    }

    $setting->delete();
    return redirect()->back()->with('dark', 'تم حذف التصنيف بنجاح');
  }

  //////////////////////////////////////////////////////////////////////////////// SubFilters

  public function subFilterView($id)
  {
    //Gate::authorize('sub_filter.view');

    $categoryId = $id;
    $settings = SubSettings::where('main_category_setting_id', $id)->get();

    return view('dashboard.filters.sub_filters', compact('settings', 'categoryId'));
  }

  public function subFilterStore(Request $request)
  {
    //Gate::authorize('sub_filter.create');


    $request->validate([
      'name' => 'required|string|min:3|max:30',
    ]);


    if (
      SubSettings::where([
        'name' => request()->input('name'),
        'main_category_setting_id' => request()->input('main_category_setting_id')
      ])->count()
    ) {

      return redirect()->back()
        ->with('danger', 'التصنيف موجود بالفعل');
    }

    SubSettings::create($request->all());

    return redirect()->back()->with('success', 'تم إنشاء التصنيف بنجاح');
  }

  public function subFilterDestroy($id)
  {
    //Gate::authorize('sub_filter.delete');

    $subSetting = SubSettings::findOrFail($id);

    if ($subSetting->products->first()) {
      return back()
        ->with('danger', 'التصنيف يوجد به منتجات لا يمكنك حذفه');
    }
    $subSetting->delete();

    return redirect()->back()->with('dark', 'تم حذف التصنيف بنجاح');
  }

  public function subFilterUpdate(Request $request, string $id)
  {
    //Gate::authorize('sub_filter.edit');

    $data = $request->validate([
      'name' => 'required|max:255'
    ]);


    $filter = SubSettings::findOrFail($id);
    $filter->update($data);

    if ($filter->wasChanged('name')) {
      return redirect()->back()->with('success', 'تم تعديل التصنيف بنجاح');
    }

    return redirect()->back()->with('dark', 'لم يتم تحديث العنصر لعدم وجود أي تغيير');
  }

  public function subFilterEdit(string $id)
  {
    //Gate::authorize('sub_filter.edit');

    $filter = SubSettings::findOrFail($id);
    return view('dashboard.filters.edit_sub_filter', compact('filter'));
  }
}
