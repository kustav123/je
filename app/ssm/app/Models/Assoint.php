<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Assoint extends Model
{
    use HasFactory;
    protected $table = 'asso_int';
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
        'updated_at',
    ];
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';
    public function productStOutInts()
    {
        return $this->hasMany(ProductStOutInt::class, 'to', 'id');
    }
    public function rawProductAdjHisInts()
    {
        return $this->hasMany(RawProductAdjHisInt::class, 'from', 'id');
    }

    public function FinproductInHisInt()
    {
        return $this->hasMany(FinproductInHisInt::class, 'aid', 'id');
    }
}
