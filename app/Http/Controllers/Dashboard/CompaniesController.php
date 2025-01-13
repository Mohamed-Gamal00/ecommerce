<?php

namespace App\Http\Controllers\Dashboard;

use App\Helper\Helper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Company\CompanyRequest;
use App\Models\Company;
use App\Repositories\Company\CompanyRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

class CompaniesController extends Controller
{
  use Helper;

  public $companyRepo;
  public function __construct(CompanyRepository $repo)
  {
    $this->companyRepo = $repo;
  }

  /**
   * Display a listing of the resource.
   */

  // create constructor to bind DesignService

  public function index()
  {
    //Gate::authorize('company.view');
    $companies = $this->companyRepo->getMainCompany();
    return view('dashboard.companies.index', compact('companies'));
  }

  /**
   * Show the form for creating a new resource.
   */
  public function create()
  {
    //Gate::authorize('company.create');
    return view('dashboard.companies.create');
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(CompanyRequest $request)
  {
    //Gate::authorize('company.create');

    $data = $request->validated();
    $data['image'] = $this->uploadedImage($request, 'image', 'companies');

    $this->companyRepo->store($data);
    return to_route('companies.index')->with('success', __('messages.COMPANY_CREATED'));
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
    //Gate::authorize('company.edit');
    $company = Company::findOrFail($id);
    return view('dashboard.companies.edit', compact('company'));
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(CompanyRequest $request, string $id)
  {
    //Gate::authorize('company.edit');
    $data = $request->validated();

    $company = $this->companyRepo->getById($id);

    $oldImage = $company->image;

    $newImage = $this->uploadedImage($request, 'image', 'companies');

    if ($newImage) {
      $data['image'] = $newImage;
    }

    if ($newImage && $oldImage) {
      Storage::disk('public')->delete($oldImage);
    }
    $this->companyRepo->update($id, $data);
    return to_route('companies.index')->with('success', __('messages.COMPANY_UPDATED'));
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(string $id)
  {
    //Gate::authorize('company.delete');
    $this->companyRepo->delete($id);
    return back()->with('dark', __('messages.COMPANY_DELETED'));
  }
}
