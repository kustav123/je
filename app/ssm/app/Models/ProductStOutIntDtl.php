<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductStOutIntDtl extends Model
{
    use HasFactory;
    protected $table = 'product_st_out_int_dtl';
    protected $primaryKey = 'id';
    const UPDATED_AT = null;
    const CREATED_AT = null;

    protected $fillable = [
        'eid', 'product', 'qty'
    ];
    public function productStOutInt()
    {
        return $this->belongsTo(ProductStOutInt::class, 'eid', 'id');
    }
    public function rawProduct()
    {
        return $this->belongsTo(Rawproducts::class, 'product', 'id');
    }

}
