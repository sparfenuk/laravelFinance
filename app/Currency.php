<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    /**
     * Returns currency rate from Privat24 API for current date
     *
     * @return array
     *
     */
   public static function getExchangeRate()
   {
       $currentDate = now()->toDateString();
       $date = date('d-m-Y',strtotime($currentDate));
       $date = str_replace('-','.',$date);

       $json = file_get_contents('https://api.privatbank.ua/p24api/exchange_rates?json&date='.$date);
       $data = json_decode($json,true);
      return $data;
   }
}
