<?php

namespace App\Console\Commands;

use App\Expense;
use App\Period;
use App\Wallet;
use Illuminate\Console\Command;

class FreshWallets extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'wallets:fresh';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Refreshing all wallets';

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
        $wallets = Wallet::all();
        foreach ($wallets as $wallet) {
            $value = 0;
            foreach ($wallet->incomes() as $income) {
                $period = Period::find($income->period_id);
                $now = new \DateTime("now");
                $diffInHours = $now->diff(new \DateTime($income->updated_at))->h;
                switch ($period->name) {
                    case "hour":
                        $value += $income->value * $diffInHours;
                        break;
                    case "day":
                        $value += $income->value * round($diffInHours / 24);
                        break;
                    case "week":
                        $value += $income->value * round($diffInHours / 168);
                        break;
                    case "2weeks":
                        $value += $income->value * round($diffInHours / 336);
                        break;
                    case "4weeks":
                        $value += $income->value * round($diffInHours / 672);
                        break;
                    case "month":
                        $value += $income->value * round($diffInHours / 720);
                        break;
                    case "year":
                        $value += $income->value * ($diffInHours / 8760);
                        break;
                }
                $wallet->balance += $value;
                $wallet->save();
            }
            foreach ($wallet->expenses() as $expense) {
                $period = Period::find($expense->period_id);
                $now = new \DateTime("now");
                $diffInHours = $now->diff(new \DateTime($period->updated_at))->h;
                switch ($period->name) {
                    case "hour":
                        $value -= $expense->value * $diffInHours;
                        break;
                    case "day":
                        $value -= $expense->value * round($diffInHours / 24);
                        break;
                    case "week":
                        $value -= $expense->value * round($diffInHours / 168);
                        break;
                    case "2weeks":
                        $value -= $expense->value * round($diffInHours / 336);
                        break;
                    case "4weeks":
                        $value -= $expense->value * round($diffInHours / 672);
                        break;
                    case "month":
                        $value -= $expense->value * round($diffInHours / 720);
                        break;
                    case "year":
                        $value -= $expense->value * ($diffInHours / 8760);
                        break;
                }
                $wallet->balance += $value;
                $wallet->save();
            }
            $this->info('Wallets refreshed successfully');
        }

    }
}
