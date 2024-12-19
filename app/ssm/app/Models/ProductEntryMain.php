<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductEntryMain extends Model
{
    use HasFactory;
    protected $table = 'product_entry_main'; // Specify the table name

    // The primary key type
    protected $keyType = 'string';

    // The primary key column name
    protected $primaryKey = 'id';

    // Indicates if the primary key is auto-incrementing
    public $incrementing = false;

    // Indicates if the model should be timestamped.
    public $timestamps = true;

    // The attributes that are mass assignable.
    protected $fillable = [
        'id',
        'chalan_no',
        'from',
        'recived_date',
        'delivary_mode',
        'total_amount',
        'total_cgst',
        'total_sgst',
        'remarks',
        'created_by'
    ];

    // If the timestamps columns are named differently, define them here
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
    public function history()
    {
        return $this->hasMany(ProductEntryHist::class, 'entry_id', 'id');
    }
    public function supplier()
    {
        return $this->belongsTo(Suppliers::class, 'from' ,'id');
    }

}
