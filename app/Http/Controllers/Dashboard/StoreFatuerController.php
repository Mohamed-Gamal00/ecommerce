<?php

namespace App\Http\Controllers\dashboard;

use App\Helper\Helper;
use App\Http\Controllers\Controller;
use App\Models\StoreFatuer;
use App\Repositories\store_featuers\StoreRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class StoreFatuerController extends Controller
{
  protected $storeRepository;

  public function __construct(StoreRepository $storeRepository)
  {
    $this->storeRepository = $storeRepository;
  }

  public function index()
  {
    $featuers = $this->storeRepository->getfeatuers();
    return view('dashboard.store_featuers.index', compact('featuers'));
  }

  public function create()
  {
    return view('dashboard.store_featuers.create');
  }

  public function store(Request $request)
  {
    $data = $request->validate([
      'image' => 'required|image|max:2048',
      'title' => 'required|string|max:255',
      'title_en' => 'nullable|string|max:255',
      'description' => 'nullable|string|max:255',
    ]);
    $data['request'] = $request; // Pass request object for image upload

    $this->storeRepository->store($data);
    return to_route('store_featuers.index')->with('success', 'تم اضافة ميزة ب نجاح');
  }

  public function edit(string $id)
  {
    $featuer = $this->storeRepository->getById($id);
    return view('dashboard.store_featuers.edit', compact('featuer'));
  }

  public function update(Request $request, string $id)
  {
    $data = $request->validate([
      'title' => 'required|string|max:255',
      'title_en' => 'nullable|string|max:255',
      'description' => 'nullable|string|max:255',
    ]);
    $data['request'] = $request; // Pass request object for image upload

    $this->storeRepository->update($id, $data);
    return to_route('store_featuers.index')->with('success', 'تم التعديل بنجاح');
  }

  public function destroy(string $id)
  {
    $this->storeRepository->delete($id);
    return back()->with('dark', 'تم الحذف ينجاح');
  }
}
