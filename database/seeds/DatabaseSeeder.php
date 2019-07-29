<?php

use App\Currency;
use App\Period;
use App\User;
use Illuminate\Database\Seeder;


class DatabaseSeeder extends Seeder
{
//    /**
//     * Seed the application's database.
//     *
//     * @return void
//     */
//    public function run()
//    {
//
//      // $this->call(CurrenciesTableSeeder);
//        /*$json = file_get_contents('https://api.privatbank.ua/p24api/exchange_rates?json&date=01.12.2014');
//        $obj = json_decode($json,true);
//        foreach ($obj['exchangeRate'] as $crl)
//        {
//
//            DB::table('currencies')->insert(
//                [
//                    'currency' => $crl['currency'],
//                ]
//            );
//
//        }*/
//
//        $this->call([
//            CurrenciesStartDataSeeder::class,
//        ]);
//
//    }
    private function getCurrencyForDate($date): void{
        $json = file_get_contents('https://api.privatbank.ua/p24api/exchange_rates?json&date=' . $date);
        $data = json_decode($json, true);
        foreach ($data['exchangeRate'] as $er) {
            if (array_key_exists('saleRate', $er)) {
                $c = new Currency;
                $c->base_currency = $er['baseCurrency'];
                $c->currency = $er['currency'];
                $c->sale_rate = $er['saleRate'];
                $c->purchase_rate = $er['purchaseRate'];
                $c->created_at = date("Y-m-d H:i:s",strtotime($date));
                $c->save();
            }
        }
    }

    //creates periods
    public function periods()
    {
        $periods = ['hour' , 'day' , 'week', '2 weeks', '4 weeks' , 'month', 'year'];

        foreach ($periods as $period) {
            $table = new Period();
            $table->name = $period;
            $table->save();
        }
    }

    //creates default user
    public function create_default_user()
    {
        $user = new User;
        $user->name = "default";
        $user->email = "default@gmail.com";
        $user->password = "default";
        $user->save();
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 7; $i > 1; $i--)
            $this->getCurrencyForDate(date('d.m.Y',strtotime("-{$i} years")));

        for ($i = 11; $i >= 0; $i--)
            $this->getCurrencyForDate(date('d.m.Y',strtotime("-{$i} months")));



        $c = new Currency();
        $c->base_currency = "UAH";
        $c->currency = "UAH";
        $c->sale_rate = 1;
        $c->purchase_rate = 1;
        $c->save();



     $this->periods();

     $this->create_default_user();

    }
}
