<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Suppliers extends Model
{
    use HasFactory;
    protected $table = 'supplier';
    const UPDATED_AT = null;
protected $fillable = [
    'id',
    'merchant_name',
    'mobile',
    'mobile_additonal',
    'email',
    'address',
    'created_at',
    'created_by',
    'status',
    'state',
    'due_ammount',
    'gst',
    'remarks',
];


    public function productEntries()
    {
        return $this->hasMany(ProductEntryMain::class, 'from', 'id');
    }
}
