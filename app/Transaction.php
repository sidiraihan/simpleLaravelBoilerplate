<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'AccountId',
        'TransactionDate',
        'Description',
        'DebitCreditStatus',
        'Amount'
    ];

    public function memberData()
    {
        return $this->belongsTo('App\Member', 'AccountId');
    }
}
