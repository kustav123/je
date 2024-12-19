<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Assoext extends Model
{
    use HasFactory;
    protected $table = 'asso_ext';
    protected $fillable = [

        'id',
        'name',
        'mobile',
        'email',
        'status',
        'address',
        'uidtype',
        'uid',
        'created_by',
        'updated_at'
    ];
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    public function productStOutExts()
    {
        return $this->hasMany(ProductStOutExt::class, 'to', 'id');
    }
    public function rawProductAdjHisExt()
    {
        return $this->hasMany(RawProductAdjHisExt::class, 'from', 'id');
    }

    public function finProductInHisExt()
    {
        return $this->hasMany(FinProductInHisExt::class, 'aid', 'id');
    }


}
