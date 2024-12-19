<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RawProductAdjHisExt extends Model
{
    use HasFactory;
    protected $table = 'rawproduct_adj_his_ext'; // Specify the table name

    // The primary key column name
    protected $primaryKey = 'id';

    // The primary key type
    protected $keyType = 'string';

    // Indicates if the primary key is auto-incrementing
    public $incrementing = false;

    // Indicates if the model should be timestamped
    public $timestamps = false;

    // The attributes that are mass assignable
    protected $fillable = [
        'id',
        'from',
        'entry_time',
        'date',
        'product',
        'qty',
        'entry_by',
        'remarks'
    ];

    // Define the relationships
    public function assoExt()
    {
        return $this->belongsTo(AssoExt::class, 'from', 'id');
    }

    public function rawProduct()
    {
        return $this->belongsTo(Rawproducts::class, 'product', 'id');
    }
}
