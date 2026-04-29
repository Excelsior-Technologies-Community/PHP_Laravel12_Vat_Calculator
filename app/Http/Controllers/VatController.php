<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\VatHistory; // NEW

class VatController extends Controller
{
    // Fixed VAT rates for countries
    protected $vatRates = [
        'IN' => 18,  // India
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
        // Validation
        $request->validate([
            'net_price' => 'required|numeric|min:1',
            'country_code' => 'required'
        ]);

        $netPrice = $request->net_price;
        $countryCode = strtoupper($request->country_code);

        $taxRate = $this->vatRates[$countryCode] ?? 0;
        $taxValue = $netPrice * ($taxRate / 100);
        $grossPrice = $netPrice + $taxValue;

        // SAVE TO DATABASE (NEW FEATURE)
        VatHistory::create([
            'net_price' => $netPrice,
            'country_code' => $countryCode,
            'vat_rate' => $taxRate,
            'vat_amount' => $taxValue,
            'gross_price' => $grossPrice,
        ]);

        return view('vat_form', compact(
            'netPrice',
            'grossPrice',
            'taxRate',
            'taxValue',
            'countryCode'
        ));
    }

    // NEW: Show History Page
    public function history()
    {
        $data = VatHistory::orderBy('id', 'asc')->get();
        return view('history', compact('data'));
    }
}