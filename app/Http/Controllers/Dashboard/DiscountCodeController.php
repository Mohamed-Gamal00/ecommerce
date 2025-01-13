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
    $products = Product::select('id', 'name')->take(10)->get();
    return view('dashboard.discount_codes.create', compact('products'));
  }


  public function searchProducts(Request $request)
  {
    $search = $request->input('q'); // Get the search term

    $products = Product::select('id', 'name')
      ->where('name', 'LIKE', "%{$search}%") // Filter based on the search term
      ->take(10) // Limit to 10 results
      ->get();

    $formattedProducts = $products->map(function ($product) {
      return ['id' => $product->id, 'text' => $product->name];
    });

    return response()->json($formattedProducts);
  }

  /**
   * Store a newly created resource in storage.
   */


  public function store(DiscountCodeRequest $request)
  {
    //Gate::authorize('discount_code.create');
    $validatedData = $request->validated();
    // $productIds = $validatedData['product_ids'];
    // Check if 'product_ids' is present in the request
    $productIds = $request->has('product_ids') ? $validatedData['product_ids'] : [];
    unset($validatedData['product_ids']);

    // dd($request->all());
    $discountCode = $this->discountRepository->store($validatedData);
    // Attach the selected products to the discount code
    if ($discountCode) {
      if (!empty($productIds)) {
        $discountCode->products()->sync($productIds);
      } else {
        // If no products are selected, apply the discount to all products
      }
    }

    return to_route('discount_code.index')->with('success', __('messages.DISCOUNT_CODE_CREATED'));
  }


  /**
   * Update the specified resource in storage.
   */


  public function edit(string $id)
  {
    //Gate::authorize('discount_code.edit');

    $products = Product::select('id', 'name')->latest()->take(10)->get();
    $discountCode = DiscountCode::findOrFail($id);

    // Decode the product_ids and ensure it returns an array
    $discountProductsIds = $discountCode->products->pluck('id')->toArray();
    // dd($discountProductsIds);

    return view('dashboard.discount_codes.edit', compact('discountCode', 'products', 'discountProductsIds'));
  }

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

    $this->discountRepository->syncProducts($id, $productIds);

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
