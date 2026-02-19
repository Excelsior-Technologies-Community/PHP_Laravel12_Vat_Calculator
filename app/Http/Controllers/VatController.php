<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class VatController extends Controller
{
    // Fixed VAT rates for countries
    protected $vatRates = [
        'DE' => 19,  // Germany
        'FR' => 20,  // France
        'IT' => 22,  // Italy
        'ES' => 21,  // Spain
        'UK' => 20,  // United Kingdom
    ];

    // Show the form
    public function index()
    {
        return view('vat_form');
    }

    // Calculate VAT
    public function calculate(Request $request)
    {
        $netPrice = $request->net_price;
        $countryCode = strtoupper($request->country_code);

        $taxRate = $this->vatRates[$countryCode] ?? 0; // default 0 if country not found
        $taxValue = $netPrice * ($taxRate / 100);
        $grossPrice = $netPrice + $taxValue;

        return view('vat_form', compact(
            'netPrice',
            'grossPrice',
            'taxRate',
            'taxValue',
            'countryCode'
        ));
    }
}
