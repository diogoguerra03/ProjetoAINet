<?php

namespace App\Http\Controllers;

use App\Http\Requests\PriceRequest;
use App\Models\Price;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\RedirectResponse;
use Illuminate\Database\QueryException;

class PriceController extends Controller
{

    public function __construct()
    {
        $this->authorizeResource(Price::class, 'price');
    }

    //Prices
    public function showPrices(): View
    {
        $price = Price::all()->first();
        return view('dashboard.prices', compact('price'));
    }

    public function updatePrices(PriceRequest $request): RedirectResponse
    {
        try {
            DB::transaction(function () use ($request) {
                $price = Price::first();
                $price->unit_price_catalog = $request->input('unit_price_catalog');
                $price->unit_price_catalog_discount = $request->input('unit_price_catalog_discount');
                $price->unit_price_own = $request->input('unit_price_own');
                $price->unit_price_own_discount = $request->input('unit_price_own_discount');
                $price->qty_discount = $request->input('qty_discount');

                $price->save();
            });

            return redirect()->back()
                ->with('alert-msg', "Price updated successfully.")
                ->with('alert-type', 'success');
        } catch (QueryException $e) {
            // Handle the exception and return an error message
            return redirect()->back()
                ->with('alert-msg', "Failed to update price. Error: " . $e->getMessage())
                ->with('alert-type', 'error');
        }
    }
}