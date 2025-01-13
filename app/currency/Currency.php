<?php

namespace App\currency;

use Illuminate\Support\Facades\DB;

class Currency
{
    public function getCurrency($price, $currentCurrency = 1)
    {
        $sessionCurrency = DB::table('currencies')->where('id', session('currency_id'))->first();

        $defaultCurrency = DB::table('currencies')->where('default_currency', true)->first();
        $code = '';


        if ($sessionCurrency) {
            $currentCurrency = $sessionCurrency->price_in_default_currency;
            $code = $sessionCurrency->code;
        } else {
            $currentCurrency = 1;
            $code = $defaultCurrency->code;
        }

        if (session('currency_id') == $defaultCurrency->id) {
            $currentCurrency = 1;
            $code = $defaultCurrency->code;
        }

        return $price * $currentCurrency . $code;
    }

    public static function getCurrencyApi($price, $currentCurrency = 1, $showCurrency = true)
    {
        $currencyId = request()->header('currencyId');
        $headerCurrency = DB::table('currencies')->where('id', $currencyId)->first();

        $defaultCurrency = DB::table('currencies')->where('default_currency', true)->first();
        $code = '';


        if ($headerCurrency) {
            $currentCurrency = $headerCurrency->price_in_default_currency;
            $code = $headerCurrency->code;
        } else {
            $currentCurrency = 1;
            $code = $defaultCurrency->code;
        }

        if (request()->header('currencyId') == $defaultCurrency->id) {
            $currentCurrency = 1;
            $code = $defaultCurrency->code;
        }

        if ($showCurrency) {
            return $price * $currentCurrency . $code;
        }
        return $price * $currentCurrency;
    }
}