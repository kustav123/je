<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductStOutInt extends Model
{
    use HasFactory;
    protected $table = 'product_st_out_int';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id', 'to', 'entry_time', 'date', 'entry_by', 'remarks'
    ];
    public function assoint()
    {
        return $this->belongsTo(Assoint::class, 'to', 'id');
    }

    public function productStOutIntDtls()
    {
        return $this->hasMany(ProductStOutIntDtl::class, 'eid', 'id');
    }

}
