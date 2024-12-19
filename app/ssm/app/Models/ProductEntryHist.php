<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductEntryHist extends Model
{
    use HasFactory;
    protected $table = 'product_entry_history'; // Specify the table name

    // The primary key columns
    protected $primaryKey = ['id', 'entry_id'];

    // The type of the primary key columns
    protected $keyType = 'int';

    // Indicates if the primary key is auto-incrementing (only applies to single-column primary keys)
    public $incrementing = false;

    // Indicates if the model should be timestamped.
    public $timestamps = true;
    const UPDATED_AT = NULL ;


    // The attributes that are mass assignable.
    protected $fillable = [
        'id',
        'entry_id',
        'product',
        'qty',
        'amount',
        'remarks'
    ];

    // Define the relationships
    public function entry()
    {
        return $this->belongsTo(ProductEntryMain::class, 'entry_id');
    }

    public function product()
    {
        return $this->belongsTo(Rawproducts::class, 'product', 'id');
    }


}
