<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductStOutExtDtl extends Model
{
    use HasFactory;
    protected $table = 'product_st_out_ext_dtl';
    protected $primaryKey = 'id';
    const UPDATED_AT = null;
    const CREATED_AT = null;

    protected $fillable = [
        'eid', 'product', 'qty'
    ];
    public function productStOutExt()
    {
        return $this->belongsTo(ProductStOutExt::class, 'eid', 'id');
    }
}
