<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $table = 'client';
    const UPDATED_AT = null;
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
        'job',
        'remarks',
        'created_by',
        'created_at',

    ];
}
