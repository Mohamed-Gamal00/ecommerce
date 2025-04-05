<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Models\Color;
use App\Models\Company;
use App\Models\MainCategory;
use App\Models\Product;
use App\Helper\Helper;
use App\Models\Choice;
use App\Models\MainCategorySetting;
use App\Models\ProductAvailability;
use App\Models\ProductFeature;
use App\Models\ProductImage;
use App\Repositories\Product\ProductRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductsController extends Controller
{

    public $productId;

    protected $productRepository;

    use Helper;

    public function __construct(ProductRepository $Repo)

    {
        $this->productRepository = $Repo;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // dd(Gate::allows('debug'));

        // dd(Gate::allows('product.view'));
        Gate::authorize('product.view');

        // $admin = Auth::guard('admin')->user();
        // dd($admin->hasAbility('product.view'));
        $products = $this->productRepository->getMainProduct();
        $categories = MainCategory::all();

        return view('dashboard.products.index', compact('products', 'categories'));
    }

    public function outOfStock()
    {
        $products = $this->productRepository->getOutOfStoch();
        $categories = MainCategory::all();

        return view('dashboard.products.out_of_stock', compact('products', 'categories'));
    }

    public function fetchChoices(Request $request)
    {
        $choices = Choice::whereNull('parent_id')->with('children')->get();
        return response()->json($choices);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        Gate::authorize('product.create');
        // $categories = MainCategory::whereNull('parent_id')->get();
        $subCategories = MainCategory::whereNull('parent_id')->with('children')->get();
        // return $choices;
        $companies = Company::all();
        $colors = Color::all();
        $availability_status = ProductAvailability::all();

        return view('dashboard.products.create', compact(
            // 'categories',
            'subCategories',
            'companies',
            'colors',
            'availability_status',
        ));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductRequest $request)
    {
        //Gate::authorize('product.create');
        $data = $request->validated();
        $data['category_id'] = $data['parent_id'];
        // dd($data);
        request()->validate([
            'images' => 'nullable|array',
        ]);

        $data['image'] = $this->uploadedImage(request(), 'image', 'products');
        $data['slug'] = str_replace(' ', '-', $request->name);
        // dd($data);

        $this->productRepository->store($data);

        return redirect()->route('products.index')
            ->with('success', __('messages.PRODUCT_CREATED'));
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
        //Gate::authorize('product.edit');
        $product = Product::with('colors', 'choices', 'chiled', 'parent', 'availability', 'features')->findOrFail($id);

        $categories = MainCategory::all();
        $subCategories = MainCategory::whereNull('parent_id')->with('children')->get();
        $productChoices = $product->choices->pluck('id')->toArray();
        // dd($productChoices);
        $companies = Company::all();
        $colors = Color::all();
        $availability_status = ProductAvailability::all();


        $productColors = $product->colors->pluck('id')->toArray();

        return view('dashboard.products.edit', compact(
            'categories',
            'productChoices',
            'companies',
            'subCategories',
            'product',
            'colors',
            'productColors',
            'availability_status'
        ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductRequest $request, string $id)
    {

        $data = $request->validated();
        $data['slug'] = str_replace(' ', '-', $request->name);
        $data['category_id'] = $data['parent_id'];

        // request()->validate([
        //   'image' => 'nullable|array',
        // ]);

        $this->productRepository->update($data, $id);

        return redirect()->route('products.index')
            ->with('success', __('messages.PRODUCT_UPDATED'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Gate::authorize('product.delete');

        $this->productRepository->delete($id);

        return redirect()->route('products.index')
            ->with('dark', __('messages.PRODUCT_DELETED'));
    }

    public function trash()
    {
        // Gate::authorize('product.trash.view');

        $products = Product::onlyTrashed()->paginate();
        return view('dashboard.products.trash', compact('products'));
    }

    public function restore(Request $request, $id)
    {
        //Gate::authorize('product.restore');
        $product = Product::onlyTrashed()->findOrFail($id);
        $product->restore();
        return redirect()->back()
            ->with('success', __('messages.PRODUCT_RESTORE'));
    }

    public function forceDelete($id)
    {
        //Gate::authorize('product.delete.forever');

        $product = Product::onlyTrashed()->findOrFail($id);
        $product->forceDelete();

        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        return redirect()->back()
            ->with('dark', __('messages.PRODUCT_REMOVED'));
    }

    public function subCategory($categoryId)
    {
        $category = MainCategory::findOrFail($categoryId);
        $subcategories = $category->settings()->select('main_category_settings.id', 'main_category_settings.name')->get();
        return response()->json($subcategories);
    }

    public function imageDelete(Request $request)
    {
        $request->validate([
            'image_id' => 'required|exists:product_images,id'
        ]);
        $image = ProductImage::find($request->image_id);
        if ($image) {
            $deletedImage = $image->delete();
            if ($deletedImage) {
                Storage::disk('public')->delete($image->image);
            }
        }
        return response()->json([
            'message' => $deletedImage ? 'Image Deleted Successfully' : 'Failed to delete image'
        ], $deletedImage ? 200 : 400);
    }
}
