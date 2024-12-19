<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nextval extends Model
{
    use HasFactory;
    protected $table = 'nextval';

    // Specify the primary key column
    protected $primaryKey = 'id';

    // Set incrementing to true, since 'id' is an auto-incrementing column
    public $incrementing = true;

    // Specify the data type of the primary key column
    protected $keyType = 'int';

    // Specify which attributes should be mass assignable
    protected $fillable = ['type', 'head'];

    // Disable timestamps if the table does not have 'created_at' and 'updated_at' columns
    public $timestamps = false;
}
