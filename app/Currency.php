<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    protected $table = 'currencies';

    public function wallets()
    {
        return $this->hasMany(Wallet::class);
    }
}
