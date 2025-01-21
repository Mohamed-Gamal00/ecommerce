<?php

namespace App\Http\Controllers\Api;

use App\Helper\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\MainCategoriesResource;
use App\Models\MainCategory;
use Illuminate\Http\Request;

class MainCategoriesController extends Controller
{
    public function mainCategories()
    {
        $allMainCategories = MainCategory::has('products')->where('parent_id', null)->get();

        if (count($allMainCategories) > 0) {
            return ApiResponse::sendResponse(200, 'Main Categories Retrieved Successfully', MainCategoriesResource::collection($allMainCategories));
        }
        return ApiResponse::sendResponse(200, 'No Main Categories To Retrieved', []);
    }

    public function submainCategories($mainCategory)
    {
        $mainCategory = MainCategory::findOrFail($mainCategory);

        //        return $mainCategory;
        $subCategories = MainCategory::where('parent_id', $mainCategory->id)
            ->with('children')
            ->get();
        
        if (count($subCategories) > 0) {
            return ApiResponse::sendResponse(200, 'Main Categories Retrieved Successfully', MainCategoriesResource::collection($subCategories));
        }
        return ApiResponse::sendResponse(200, 'No Main Categories To Retrieved', []);
    }

    public function allMainCategories(Request $request)
    {
        $allMainCategories = MainCategory::has('products')->get();

        if (count($allMainCategories) > 0) {
            return ApiResponse::sendResponse(200, 'All Main Categories Retrieved Successfully', MainCategoriesResource::collection($allMainCategories));
        }
        return ApiResponse::sendResponse(200, 'No Main Categories To Retrieved', []);
    }
}
