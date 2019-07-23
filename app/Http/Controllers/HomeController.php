<?php

namespace App\Http\Controllers;

use App\Currency;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
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

        return \response()->json([ 'EUR' => $eur, 'USD' => $usd, ],200);
    }

    public function getLastCurrencies(){
        /*
         * SELECT `currency`,  GROUP_CONCAT(`sale_rate` SEPARATOR ';'), `created_at`
            FROM `laravel`.`currencies`
            group by currency
            order by created_at
         */
        $currencies = DB::select("SELECT `currency`,  GROUP_CONCAT(`sale_rate` SEPARATOR ';') as data, avg(created_at) as created_at
            FROM `laravel`.`currencies`
            group by currency
            having AVG (created_at)");
//        $currencies = DB::table('currencies')
//            ->select(DB::raw(('currency,  GROUP_CONCAT(sale_rate SEPARATOR \';\') as data')))
//            ->groupBy(['currency'])
//            ->havingRaw('AVG (created_at)')
//            ->get();
        return new JsonResponse($currencies,200);
    }
}
