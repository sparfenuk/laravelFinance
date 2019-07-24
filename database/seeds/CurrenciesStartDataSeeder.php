<?php

use App\Currency;
use Illuminate\Database\Seeder;

class CurrenciesStartDataSeeder extends Seeder
{
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
    }
}
