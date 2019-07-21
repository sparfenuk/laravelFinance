<?php

namespace App\Http\Controllers;

use App\Currency;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function getCurrenciesSection()
    {

        $eur = Currency::where('currency','EUR')->first();
        $usd = Currency::where('currency','USD')->first();

        $response = [
            'EUR' => $eur,
            'USD' => $usd,
        ];

        return($response);
    }
}
