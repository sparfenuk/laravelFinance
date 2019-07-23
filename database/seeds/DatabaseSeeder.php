<?php

use Illuminate\Database\Seeder;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
      // $this->call(CurrenciesTableSeeder);
        $json = file_get_contents('https://api.privatbank.ua/p24api/exchange_rates?json&date=01.12.2014');
        $obj = json_decode($json,true);
        foreach ($obj['exchangeRate'] as $crl)
        {

            DB::table('currencies')->insert(
                [
                    'currency' => $crl['currency'],
                ]
            );

        }
    }
}
