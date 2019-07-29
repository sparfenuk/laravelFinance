<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Income extends Model
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function wallet()
    {
        return $this->belongsTo(Wallet::class);
    }

    public function period()
    {
        return $this->belongsTo(Period::class);
    }
}
