<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    public function sender()
    {
        return $this->belongsTo(Wallet::class, 'from');
    }

    public function receiver()
    {
        return $this->belongsTo(Wallet::class, 'to');
    }
}
