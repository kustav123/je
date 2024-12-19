<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Finishproducts extends Model
{
    use HasFactory;
    protected $table = 'finish_product';

    const UPDATED_AT = null;

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

    public function FinproductInHisInt()
    {
        return $this->hasMany(FinproductInHisInt::class, 'product', 'id');
    }
    public function finProductInHisExt()
    {
        return $this->hasMany(FinProductInHisExt::class, 'product', 'id');
    }
}
