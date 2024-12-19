<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appinfo extends Model
{
    use HasFactory;
    protected $table = 'appinfo';
    protected $fillable = [
        'id',
        'name',
        'logo',
        'address',
        'gstno',
        'type',
        'apptype',
        'bank_account_holder_name',
        'bank_name',
        'bank_branch',
        'bank_ac_no',
        'bank_ifsc'
    ];
}
