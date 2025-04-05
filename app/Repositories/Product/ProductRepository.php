<?php

namespace App\Repositories\Product;

use App\Helper\Helper;

use App\Models\Product;
use App\Models\ProductFeature;
use App\Models\ProductImage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProductRepository implements ProudctInterface
{
    use Helper;

    protected $product;

    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    public function getMainProduct()
    {
        $request = request();
        return $this->product->latest()->with('parent', 'sub_category', 'availability')->filter($request->query())->paginate();
    }

    public function getOutOfStoch()
    {
        $request = request();
        return $this->product->latest()->with('parent', 'sub_category', 'availability')->filter($request->query())->where('quantity', '<', 5)->paginate();
    }

    public function update($data, $id)
    {
        $product = $this->getById($id);
        $oldImage = $product->image;
        $newImage = $this->uploadedImage(request(), 'image', 'products');

        if ($newImage) {
            $data['image'] = $newImage;
        }

        if ($newImage && $oldImage) {
            Storage::disk('public')->delete($oldImage);
        }

        // dd($data);


        return DB::transaction(function () use ($data, $product) {

            if (request()->has('header')) {
                foreach (request()->header as $key => $value) {
                    if (isset($value['image'])) {
                        $currentImage = $value['image']->store('uploads/products_image', 'public');
                        ProductImage::create([
                            'image' => $currentImage,
                            'product_id' => $product->id
                        ]);
                    }
                }
            }

            // if (request()->hasFile('images')) {
            //   foreach (request()->file('images') as $image) {
            //     $currentImage = $image->store('uploads/products_image', 'public');
            //     $newProductImage = new ProductImage();
            //     $newProductImage->image = $currentImage;
            //     $newProductImage->product_id = $product->id;
            //     $newProductImage->save();
            //   }
            // }

            $product->update($data);
            $product->colors()->sync(request()->post('colors'));

            $requestFeatureIds = [];
            if (request()->product_features) {
                foreach (request()->product_features as $feature) {
                    if (!empty($feature['feature_name']) && !empty($feature['feature_description'])) {
                        ProductFeature::updateOrCreate(
                            ['id' => $feature['feature_id']],
                            [
                                'feature_name' => $feature['feature_name'],
                                'feature_name_en' => $feature['feature_name_en'],
                                'feature_description' => $feature['feature_description'],
                                'product_id' => $product->id
                            ]
                        );
                    }
                    $requestFeatureIds[] = $feature['feature_delete'] ?? null;
                }
            }

            $dbFeatureIds = ProductFeature::where('product_id', $product->id)->pluck('id')->toArray();
            $idsToDelete = array_diff_key($dbFeatureIds, $requestFeatureIds);

            if ($idsToDelete) {
                ProductFeature::whereIn('id', $idsToDelete)->delete();
            }

            if (request()->has('choice_id')) {
                // dd(request()->has('choice_id'));
                $product->choices()->sync(request()->input('choice_id'));
            }
            // dd($data);
            return $product;
        });
    }

    public function getById($id)
    {
        return $this->product->with('colors', 'chiled', 'parent', 'availability', 'features')->findOrFail($id);
    }

    // protected function uploadedImage($request, $key, $folder)
    // {
    //     if ($request->hasFile($key)) {
    //         return $request->file($key)->store($folder, 'public');
    //     }
    //     return null;
    // }

    public function store($data)
    {
        return DB::transaction(function () use ($data) {
            $product = $this->product->create($data);

            // Create product features if exists
            if (request()->has('product_features')) {
                foreach (request()->product_features as $feature) {
                    if (!empty($feature['feature_name']) && !empty($feature['feature_description'])) {
                        ProductFeature::create([
                            'feature_name' => $feature['feature_name'],
                            'feature_name_en' => $feature['feature_name_en'],
                            'feature_description' => $feature['feature_description'],
                            'product_id' => $product->id
                        ]);
                    }
                }
            }


            if (request()->has('header')) {
                foreach (request()->header as $key => $value) {
                    if (isset($value['image']) || isset($value['image_link'])) {
                        $currentImage = $value['image']->store('uploads/products_image', 'public');
                        // dd($currentImage);
                        ProductImage::create([
                            'image' => $currentImage,
                            'product_id' => $product->id
                        ]);
                    }
                }
            }

            // if (request()->hasFile('image')) {
            //   foreach (request()->file('image') as $image) {
            //     $currentImage = $image->store('uploads/products_image', 'public');
            //     // dd($currentImage);
            //     ProductImage::create([
            //       'image' => $currentImage,
            //       'product_id' => $product->id
            //     ]);
            //   }
            // }

            $product->colors()->attach(request()->input('colors'));


            if (request()->has('choice_id')) {
                // dd(request()->has('choice_id'));
                $product->choices()->attach(request()->input('choice_id'));
            }


            return $product;
        });
    }

    public function delete($id)
    {
        return DB::transaction(function () use ($id) {
            $product = $this->getById($id);

            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            // Delete associated product images
            $images = ProductImage::where('product_id', $product->id)->get();
            foreach ($images as $image) {
                // Delete the image file from storage
                Storage::disk('public')->delete($image->image);

                // Delete the image record from the database
                $image->delete();
            }

            // Delete the product
            $product->delete();

            return $product;
        });
    }


    // public function forceDelete($id) // لتشغيلها قم بتفعيل السوفت دليت من الموديل بتاع المنتج
    // {
    //     $product = $this->product->onlyTrashed()->findOrFail($id);
    //     $product->forceDelete();

    //     if ($product->image) {
    //         Storage::disk('public')->delete($product->image);
    //     }

    //     return $product;
    // }
}
