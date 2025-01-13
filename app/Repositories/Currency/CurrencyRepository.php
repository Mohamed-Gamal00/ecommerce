<?php

namespace App\Repositories\Currency;

use App\Helper\Helper;
use App\Models\Currency;
use Illuminate\Support\Facades\Storage;

/*
    Separates databases layer from services layer
    contain all databse work
    handel the database operation as create update delete ..
*/

class CurrencyRepository implements CurrencyInterface
{

  use Helper;
  public $currency;
  public function __construct(Currency $currency)
  {
    $this->currency = $currency;  // Ready-instance model of currency
  }

  public function getMainCurrency()
  {
    return $this->currency->where('status', 'used')
      ->where('default_currency', false)
      ->get();
  }
  public function getDefaultCurrency()
  {
    return $this->currency->where('default_currency', true)->first();
  }

  public function store($data)
  {
    return $this->currency->where('id', $data['currency_id'])->update([
      'status' => 'used',
      'price_in_default_currency' => $data['price_in_default_currency']
    ]);
  }

  public function getById($id)
  {
    return $this->currency->findOrFail($id);
  }

  public function update($data, $id)
  {
    $currentCurrency = $this->getById($id);
    if ($currentCurrency->price_in_default_currency != $data['price_in_default_currency'] || $currentCurrency->id != $data['currency_id']) {
      $currentCurrency->update([
        'status' => 'not_used',
        'price_in_default_currency' => null
      ]);

      $newCurrency = Currency::find($data['currency_id']);
      // dd($newCurrency);

      $newCurrency->update([
        'status' => 'used',
        'price_in_default_currency' => $data['price_in_default_currency']
      ]);
      return $newCurrency->wasChanged();
    }
  }

  public function delete($id)
  {
    $currency = $this->currency->findOrFail($id);
    $currency->where('id', $id)->update([
      'status' => 'not_used',
      'price_in_default_currency' => null
    ]);
  }
  public function updateDefaultCurrency($data)
  {
    $oldDefaultCurrency = $this->currency->where('default_currency', true)->first();
    if ($oldDefaultCurrency) {
      $oldDefaultCurrency->update(['default_currency' => false]);
    }

    $newDefaultCurrency = $this->currency->where('id', $data['default_currency_id'])->first();
    if ($newDefaultCurrency) {
      $newDefaultCurrency->update(['default_currency' => true, 'status' => 'used']);
    }
  }
}
