<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientPayment extends Model
{
    use HasFactory;

    protected $table = 'client_payment';
    const UPDATED_AT = null;

    protected $primaryKey = 'id';

    protected $fillable = [
        'payid',
        'clid',
        'date',
        'paymentmode',
        'paidamount',
        'remarks',
        'data_invoice',
        'created_by',
        'comp',
        'tid'
    ];

    protected $casts = [
        'date' => 'date',
        'paidamount' => 'double'
    ];

    // Define relationships
    public function client()
    {
        return $this->belongsTo(Client::class, 'clid');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
