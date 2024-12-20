<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductStOutExt extends Model
{
    use HasFactory;
    protected $table = 'product_st_out_ext';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id', 'to', 'entry_time', 'date', 'entry_by', 'remarks'
    ];
    public function assoext()
    {
        return $this->belongsTo(Assoext::class, 'to', 'id');
    }

    public function productStOutExtDtls()
    {
        return $this->hasMany(ProductStOutExtDtl::class, 'eid', 'id');
    }

}
