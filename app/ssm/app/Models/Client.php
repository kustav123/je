<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $table = 'client';
    protected $fillable = [
        'id',
        'name',
        'mobile',
        'mobile_additonal',
        'email',
        'address',
        'status',
        'due_ammount',
        'gst',
        'state',
        'remarks',
        'created_by',
        'created_at',

    ];
}
