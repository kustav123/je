<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FinproductInHisInt extends Model
{
    use HasFactory;
    protected $table = 'finproduct_in_his_int'; // Specify the table name


  // The primary key column name
  protected $primaryKey = 'id';

  // The primary key type
  protected $keyType = 'string';

  // Indicates if the primary key is auto-incrementing
  public $incrementing = false;

  // Indicates if the model should be timestamped
  public $timestamps = false;


    // The attributes that are mass assignable.
    protected $fillable = [
       'id',
        'aid',
        'product',
        'qty',
        'date'
    ];
    // Define the relationship with the asso_int model
    public function assoInt()
    {
        return $this->belongsTo(Assoint::class, 'aid', 'id');
    }

    // Define the relationship with the raw_product model
    public function Finishproducts()
    {
        return $this->belongsTo(Finishproducts::class, 'product', 'id');
    }
}
