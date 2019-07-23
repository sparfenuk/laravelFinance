<?php

namespace App\Http\Controllers;

use App\Currency;
use App\User;
use App\Wallet;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class WalletController extends Controller
{
    /**
     * Display a listing of the resource.
     * @param  \Illuminate\Http\Request $request
     * @return JsonResponse
     */
    public function index(Request $request)
    {
        if($request->isMethod('delete'))
        {
            //Wallet::where('id',$request['wallet_id'])->delete;
           return new JsonResponse(['succes'=>$request['wallet_id']],200);
        }
        if($request->ajax()) {


            $request->validate([
                'wallet_name' => 'required|max:14',
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
            $currencies = Currency::all();

            return view('wallets.index')->with(['wallets' => $user->wallets, 'currencies' => $currencies]);
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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

    /**
     * Remove the specified resource from storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return JsonResponse
     */
    public function destroy($request)
    {
        if ($request->ajax())
        {}
        return new JsonResponse('success',200);
    }
}
