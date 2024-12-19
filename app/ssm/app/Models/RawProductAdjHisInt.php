<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RawProductAdjHisInt extends Model
{
    use HasFactory;

    protected $table = 'rawproduct_adj_his_int';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'from',
        'entry_time',
        'date',
        'product',
        'qty',
        'entry_by',
        'remarks',
    ];

    public $timestamps = false;

    /**
     * Get the asso_int that owns the RawProductAdjHisInt.
     */
    public function assoInt()
    {
        return $this->belongsTo(AssoInt::class, 'from');
    }

    /**
     * Get the raw_product that owns the RawProductAdjHisInt.
     */
    public function rawProduct()
    {
        return $this->belongsTo(RawProducts::class, 'product');
    }

    public function rawProductAdjHisInts()
    {
        return $this->hasMany(RawProductAdjHisInt::class, 'product');
    }
}
