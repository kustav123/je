<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rawproducts extends Model
{
    use HasFactory;
    protected $table = 'raw_product';

    // Disable the 'updated_at' timestamp

    // Specify the fillable attributes
    protected $fillable = [
        'id',
        'name',
        'created_at',
        'created_by',
        'unit',
        'current_stock',
        'remarks',
        'status'
    ];
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    public function productStOutExtMaps()
    {
        return $this->hasMany(ProductStOutExtMap::class, 'product', 'id');
    }

    public function productStOutIntMaps()
    {
        return $this->hasMany(ProductStOutIntMap::class, 'product', 'id');
    }

    public function productEntryHists()
    {
        return $this->hasMany(ProductEntryHist::class, 'product', 'id');
    }

    public function rawProductAdjHisExt()
    {
        return $this->hasMany(RawProductAdjHisExt::class, 'product', 'id');
    }
}
