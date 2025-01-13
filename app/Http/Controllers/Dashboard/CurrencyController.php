<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\currencies\CurrencygRequest;
use App\Models\Currency;
use App\Repositories\Currency\CurrencyRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class CurrencyController extends Controller
{
  public $currencyRepo;
  public function __construct(CurrencyRepository $repo)
  {
    $this->currencyRepo = $repo;
  }
  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    //Gate::authorize('currency.view');

    $currencies = $this->currencyRepo->getMainCurrency();
    $defaultCurrency = $this->currencyRepo->getDefaultCurrency();

    return view('dashboard.currencies.index', compact('currencies', 'defaultCurrency'));
  }

  /**
   * Show the form for creating a new resource.
   */
  public function create()
  {
    //Gate::authorize('currency.create');
    $currencies = Currency::where('default_currency', false)->get();
    $defaultCurrency = Currency::where('default_currency', true)->first();
    return view('dashboard.currencies.create', compact('currencies', 'defaultCurrency'));
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(CurrencygRequest $request)
  {
    //Gate::authorize('currency.create');

    $data = $request->validated();

    $this->currencyRepo->store($data);

    return \to_route('currencies.index')->with('success', __('messages.CURRENCY_CREATED'));
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
    //Gate::authorize('currency.edit');

    $currencies = Currency::where('default_currency', false)->get();
    $currentCurrency = Currency::where('id', $id)->first();
    $defaultCurrency = Currency::where('default_currency', true)->first();

    return view('dashboard.currencies.edit', compact('currencies', 'currentCurrency', 'defaultCurrency'));
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(CurrencygRequest $request, string $id)
  {
    //Gate::authorize('currency.edit');

    $data = $request->validated();

    $washChanged = $this->currencyRepo->update($data, $id);

    if ($washChanged) {
      return \to_route('currencies.index')->with('success', __('messages.CURRENCY_UPDATED'));
    }
    return \to_route('currencies.index')->with('info', 'لم يتم التعديل لعدم وجود أي تغيير');
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(string $id)
  {
    //Gate::authorize('currency.delete');
    $this->currencyRepo->delete($id);
    return \to_route('currencies.index')->with('dark', __('messages.CURRENCY_DELETED'));
  }

  public function setDefaultCurrency()
  {
    //Gate::authorize('currency.create');
    $currencies = Currency::get();
    $defaultCurrency = Currency::where('default_currency', true)->first();
    return view('dashboard.currencies.default_currency', compact('currencies', 'defaultCurrency'));
  }

  public function updateDefaultCurrency(Request $request)
  {
    //Gate::authorize('currency.edit');

    $data = $request->validate([
      'default_currency_id' => 'required|exists:currencies,id'
    ]);

    $this->currencyRepo->updateDefaultCurrency($data);

    return \to_route('currencies.index')->with('success', __('messages.UPDATE_DEFUALT_CURRENCY'));
  }
}
