<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuppPay extends Model

{
    protected $table = 'sc_payment_entry';
    const UPDATED_AT = NULL ;
    use HasFactory;

    protected $fillable = [
        'id',
        'scid',
        'amount',
        'mode',
        'hisamount',
        'curamount',
        'remarks',
        'frmaccount',
        'frmbnk',
        'created_by',
        'trid',
        'compid'
    ];

}
