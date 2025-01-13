<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\MainCategory;
use App\Models\MainCategorySetting;
use App\Models\Product;
use App\Models\SubSettings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class ProductSettingsController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    //Gate::authorize('product_setting.view');

    $request = request();
    $products = Product::latest()->with('parent', 'chiled')->filter($request->query())
      ->withoutTrashed()->paginate(10);

    $categories = MainCategory::all();


    return view('dashboard.product_settings.index', compact('products', 'categories'));
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
    //
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
    //
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, string $id)
  {
    //
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy() {}

  public function destroyAll(Request $request)
  {
    //Gate::authorize('product.delete');

    // will return empty array if the there is no ids
    $ids = $request->input('productId', []);

    // Delete records and get the number of deleted items
    $deletedCount = Product::whereIn('id', $ids)->delete();

    if ($deletedCount > 0) {
      return redirect()->back()->with('dark', 'تم حذف ' . $deletedCount . ' عنصر بنجاح');
    } else {
      return redirect()->back()->with('dark', 'لم يتم حذف أي عناصر.');
    }
  }

  public function productFilters($id)
  {
    //Gate::authorize('product_setting.filters');
    $productFilter = Product::with('subSettings', 'chiled.subSettings')->where('id', $id)->first();

    return view('dashboard.product_settings.create_filter', compact('productFilter'));
  }

  public function productFiltersUpdate($id)
  {
    //Gate::authorize('product_setting.filters');

    $product = Product::findOrFail($id);
    $sync = $product->subSettings()->sync(request()->input('filters', []));

    if (empty($sync['attached'] || $sync['detached'])) {
      return redirect()->back()->with('dark', 'لم يتم تحديث العنصر لعدم وجود أي تغيير');
    }

    return redirect()->back()->with('success', 'تم التحديث بنجاح');
  }
}
