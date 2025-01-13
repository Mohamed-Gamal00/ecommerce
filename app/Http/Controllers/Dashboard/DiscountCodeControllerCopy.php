<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\DiscountCodeRequest;
use App\Models\DiscountCode;
use App\Models\Product;
use App\Repositories\Discount_codes\DiscountRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class DiscountCodeController extends Controller
{

  protected $discountRepository;

  public function __construct(DiscountRepository $discountRepository)
  {
    $this->discountRepository = $discountRepository;
  }
  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    //Gate::authorize('discount_code.view');

    $discounts = $this->discountRepository->getMainDiscountCode();
    return view('dashboard.discount_codes.index', compact('discounts'));
  }

  /**
   * Show the form for creating a new resource.
   */
  public function create()
  {
    //Gate::authorize('discount_code.create');
    $products = Product::select('id', 'name')->get();
    return view('dashboard.discount_codes.create', compact('products'));
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(DiscountCodeRequest $request)
  {
    //Gate::authorize('discount_code.create');

    // $request->validated();
    $validatedData = $request->validated();

    // $request->merge([
    //   'product_ids' => \json_encode($request->product_ids)
    // ]);
    $productIds = $validatedData['product_ids'];
    unset($validatedData['product_ids']);

    // dd($request->all());
    $discountCode = $this->discountRepository->store($validatedData);
    // Attach the selected products to the discount code
    if ($discountCode && !empty($productIds)) {
      $discountCode->products()->sync($productIds);
    }

    // $this->discountRepository->store($request->all());

    return to_route('discount_code.index')->with('success', __('messages.DISCOUNT_CODE_CREATED'));
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(string $id)
  {
    //Gate::authorize('discount_code.edit');

    $products = Product::select('id', 'name')->get();
    $discountCode = DiscountCode::findOrFail($id);

    // Decode the product_ids and ensure it returns an array
    $discountProductsIds = $discountCode->products->pluck('id')->toArray();
    // dd($discountProductsIds);

    return view('dashboard.discount_codes.edit', compact('discountCode', 'products', 'discountProductsIds'));
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(DiscountCodeRequest $request, string $id)
  {
    //Gate::authorize('discount_code.edit');

    // Validate the request data
    $data = $request->validated();

    // Extract and remove product_ids from the validated data
    $productIds = $data['product_ids'] ?? [];
    unset($data['product_ids']);

    // Update the discount code
    $wasChanged = $this->discountRepository->update($data, $id);

    // Update the product associations if there are any product_ids provided
    if (!empty($productIds)) {
      $this->discountRepository->syncProducts($id, $productIds);
    }

    if ($wasChanged || !empty($productIds)) {
      return to_route('discount_code.index')->with('success', __('messages.DISCOUNT_CODE_UPDATED'));
    }

    return to_route('discount_code.index')->with('warning', 'لم يتم التعديل لعدم وجود أي تغيير');
  }


  /**
   * Remove the specified resource from storage.
   */
  public function destroy(string $id)
  {
    //Gate::authorize('discount_code.delete');

    $this->discountRepository->delete($id);
    return to_route('discount_code.index')->with('dark', __('messages.DISCOUNT_CODE_DELETED'));
  }
}
