<?php

namespace App\Http\Controllers;

use App\Currency;
use App\Expense;
use App\Income;
use App\Period;
use App\User;
use App\Wallet;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class WalletController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     * @param  \Illuminate\Http\Request $request
     * @return JsonResponse
     */
    public function index(Request $request)
    {
        if($request->isMethod('delete'))
        {
            if (isset($request['wallet_id'])) {
                Wallet::where('id', $request['wallet_id'])->delete();
                return new JsonResponse(['succes' => $request['wallet_id']], 200);
            }
        }
        else if($request->ajax()) {


            $request->validate([
                'wallet_name' => 'nullable|max:14',
                'wallet_description' => 'nullable|max:30',
            ]);

            $wallet = new Wallet();
            $wallet->user_id = auth()->id();
            $wallet->name = $request['wallet_name'];
            $wallet->description = $request['wallet_description'];
            $wallet->currency_id = $request['currency_id'];
            $wallet->timestamps = now();
            $wallet->save();

            $json = [
                'wallet_name'=>$wallet->name,
                'wallet_description'=>$wallet->description,
                'currency' => $wallet->currency->currency,
                'balance' => 0,
            ];

            return new JsonResponse($json,200);
        }

        else if(Auth::check()) {
            $user_id = auth()->id();
            $user = User::find($user_id);
            //$currencies = Currency::all();
            $currencies_unique = DB::table('currencies')
                ->select()
                ->groupBy('currency')
                ->get();
            return view('wallets.index')->with(['wallets' => $user->wallets, 'currencies' => $currencies_unique]);
        }
        else
          return  redirect('login');
    }

//    /**
//     * Show the form for creating a new resource.
//     * @param  \Illuminate\Http\Request $request
//     * @return JsonResponse
//     */
//    public function create(Request $request)
//    {
//
//        if($request->ajax()) {
//            $wallet = new Wallet();
//            // dd($request);
//            $wallet->user_id = auth()->id();
//            $wallet->currency_id = $request['currency_id'];
//            $wallet->timestamps = now();
//            $wallet->save();
//            return new JsonResponse('success',200);
//        }
//
//        if(auth()->id() == NULL)
//        {
//            return redirect('home');
//        }
//        else {
//            $currencies = Currency::all();
//            return view('wallets.create')->with('currencies', $currencies);
//        }
//    }

//    /**
//     * Store a newly created resource in storage.
//     *
//     * @param  \Illuminate\Http\Request $request
//     * @return \Illuminate\Http\JsonResponse
//     */
//    public function store(Request $request)
//    {
//        if($request->ajax()) {
//            $wallet = new Wallet();
//           // dd($request);
//            $wallet->user_id = auth()->id();
//            $wallet->currency_id = $request['currency_id'];
//            $wallet->timestamps = now();
//            $wallet->save();
//            return response()->json(['success'=>'data added'],200);
//        }
//        else {
//            return response()->json(['error'],500);
//        }
//
//    }
//
//    /**
//     *
//     * @param  \Illuminate\Http\Request $request
//     * @return \Illuminate\Http\JsonResponse
//     */
//    public function storeAjax(Request $request)
//    {
//        if($request->ajax()) {
//            $wallet = new Wallet();
//            // dd($request);
//            $wallet->user_id = auth()->id();
//            $wallet->currency_id = $request['currency_id'];
//            $wallet->timestamps = now();
//            $wallet->save();
//            return response()->json(['success'=>'data added'],200);
//        }
//        else {
//            return response()->json(['error'],500);
//        }
//
//    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @param Request $request
     * @return JsonResponse|\Illuminate\Http\Response
     */
    public function show($id,Request $request)
    {

        if($request->ajax()) {

            $json = [];

            if($request['type'] == 'income') {
                $request->validate([
                    'income_name' => 'nullable|max:14',
                    'income_description' => 'nullable|max:30',
                ]);

                $income = new Income();
                $income->user_id = auth()->id();
                $income->name = $request['income_name'];
                $income->description = $request['income_description'];
                $income->wallet_id = $request['wallet_id'];
                $income->period_id = $request['period_id'];
                $income->value = $request['income_value'];
                $income->timestamps = now();
                $income->save();

                $json = [
                    'income_name' => $income->name,
                    'income_description' => $income->description,
                    'income_period' => $income->period->name,
                    'income_value' => $income->value,
                ];
            }
            else if($request['type'] == 'expense') {
                $request->validate([
                    'expense_name' => 'nullable|max:14',
                    'expense_description' => 'nullable|max:30',
                ]);

                $expense = new Expense();
                $expense->user_id = auth()->id();
                $expense->name = $request['expense_name'];
                $expense->description = $request['expense_description'];
                $expense->wallet_id = $request['wallet_id'];
                $expense->period_id = $request['period_id'];
                $expense->value = $request['expense_value'];
                $expense->timestamps = now();
                $expense->save();

                $json = [
                    'expense_name' => $expense->name,
                    'expense_description' => $expense->description,
                    'expense_period' => $expense->period->name,
                    'expense_value' => $expense->value,
                ];
            }
            return new JsonResponse($json,200);
        }


        if(isset($id) && is_numeric($id)) {
            $wallet = Wallet::find($id);
            if ($wallet !== null && $wallet->user_id === \auth()->id()) {
                $incomes = $wallet->incomes;
                $expenses = $wallet->expenses;
                $periods = Period::all();
               // $enum_once_per = self::get_enum_values($incomes->getTable(),'once_per');

                return view('wallets.show', [
                    'wallet' => $wallet,
                    'incomes' => $incomes,
                    'expenses' => $expenses,
                    'periods' => $periods,
                ]);
            }
            else
            return  redirect('wallets');
        }
        else
            abort(404);
    }

//   public static function get_enum_values( $table, $field )
//    {
//        $type = DB::select(DB::raw( "SHOW COLUMNS FROM {$table} WHERE Field = '{$field}'" ))[0]->Type;
//        preg_match("/^enum\(\'(.*)\'\)$/", $type, $matches);
//        $enum = explode("','", $matches[1]);
//        return $enum;
//    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

//    /**
//     * Remove the specified resource from storage.
//     *
//     * @param \Illuminate\Http\Request $request
//     * @return JsonResponse
//     */
//    public function destroy($request)
//    {
//        if ($request->ajax())
//        {}
//        return new JsonResponse('success',200);
//    }
}
