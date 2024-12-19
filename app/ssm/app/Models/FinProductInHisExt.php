<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FinProductInHisExt extends Model
{
    use HasFactory;

    protected $table = 'finproduct_in_his_ext'; // Specify the table name

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
        'aid',
        'product',
        'date',
        'qty'
    ];

    // Define the relationships
    public function assoExt()
    {
        return $this->belongsTo(AssoExt::class, 'aid', 'id');
    }

    public function finishProduct()
    {
        return $this->belongsTo(FinishProducts::class, 'product', 'id');
    }
}
