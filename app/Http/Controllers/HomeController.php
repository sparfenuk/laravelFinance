<?php

namespace App\Http\Controllers;

use App\Currency;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\JsonResponse;

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

    public function getLastCurrencies(){
        /*
         * SELECT `currency`,  GROUP_CONCAT(`sale_rate` SEPARATOR ';'), `created_at`
            FROM `laravel`.`currencies`
            group by currency
            order by created_at
         */
        $currencies = DB::select(DB::raw('SELECT currency,  GROUP_CONCAT(sale_rate SEPARATOR \';\'), created_at FROM currencies group by currency order by created_at'));
        return new JsonResponse($currencies,200);
    }
}
