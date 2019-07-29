<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{

    protected $guarded = [];

    public function  user()
    {
        return $this->belongsTo(User::class);
    }

    public function currency()
    {
      return  $this->belongsTo(Currency::class);
    }

    public function incomes()
    {
        return $this->hasMany(Income::class);
    }

    public function expenses()
    {
        return $this->hasMany(Expense::class);
    }
}
