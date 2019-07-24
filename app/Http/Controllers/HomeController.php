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
        //$this->middleware('auth');
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

    public function welcome(){
        $dates = DB::table('currencies')
            ->select(DB::raw('Date(created_at) as created_at'))
            ->groupBy('created_at')
            ->get();
        $currencies = DB::table('currencies')
            ->select(DB::raw(('currency,  GROUP_CONCAT(sale_rate SEPARATOR \';\') as data')))
            ->groupBy(['currency'])
            ->where('currency','!=', 'UAH')
            ->limit(20)
            ->get();
        return view('welcome')
            ->with('dates', $dates)
            ->with('currencies',$currencies);
    }

    public function getCurrenciesSection()
    {

        $eur = Currency::where('currency','EUR')->orderBy('id','desc')->first();
        $usd = Currency::where('currency','USD')->orderBy('id','desc')->first();

        return \response()->json([ 'EUR' => $eur, 'USD' => $usd, ],200);
    }

    public function getLastCurrencies(){
        $currencies = DB::table('currencies')
            ->select(DB::raw(('currency,  GROUP_CONCAT(sale_rate SEPARATOR \';\') as data')))
            ->groupBy(['currency'])
            ->where('currency','!=', 'UAH')
            ->limit(20)
            ->get();


        return new JsonResponse($currencies,200);
    }
}
