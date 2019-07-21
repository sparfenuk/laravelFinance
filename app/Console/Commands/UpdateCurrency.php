<?php

namespace App\Console\Commands;

use App\Currency;
use Illuminate\Console\Command;

class UpdateCurrency extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'currency:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Updating currency rate';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        Currency::query()->truncate();//purging table
        $date = date('d.m.Y');
        $json = file_get_contents('https://api.privatbank.ua/p24api/exchange_rates?json&date=' . $date);
        $data = json_decode($json, true);
        foreach ($data['exchangeRate'] as $er) {
            if (array_key_exists('saleRate', $er)) {
                $c = new Currency;
                $c->base_currency = $er['baseCurrency'];
                $c->currency = $er['currency'];
                $c->sale_rate = $er['saleRate'];
                $c->purchase_rate = $er['purchaseRate'];
                $c->save();
            }
        }
        $this->info('Currencies successfully updated!');
    }
}
