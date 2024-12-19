<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hsn extends Model
{
    use HasFactory;
    protected $table = 'hsn';
    const UPDATED_AT = null;
    protected $fillable = [
        'id',
        'name',
        'status',
        'cgst',
        'sgst',
        'created_at',
    ];
}
