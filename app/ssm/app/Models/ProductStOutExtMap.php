<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class ProductStOutExtMap extends Model
{
    use HasFactory;
    protected $table = 'product_st_out_ext_map';
    protected $primaryKey = 'id';
    const UPDATED_AT = null;
    const CREATED_AT = null;

    protected $fillable = [
       'id', 'aid', 'product', 'qty'
    ];

    public static function updateOrInsertProduct($clid, $product)
    {
        $existingEntry = self::where('aid', $clid)
                            ->where('product', $product['product_id'])
                            ->first();

        if ($existingEntry) {
            $existingEntry->qty += $product['quantity'];
            $existingEntry->save();
            return $existingEntry;
        } else {
            return self::create([
                'aid' => $clid,
                'product' => $product['product_id'],
                'qty' => $product['quantity']
            ]);
        }
    }
    public static function adjustProductext($product)
    {
        // Log::info($product);
        $existingEntry = self::where('id', $product['rid'])
        ->first();
        $existingEntry->qty -= $product['quantity'];
        $existingEntry->save();
        return $existingEntry;


     }
    public function rawProduct()
    {
        return $this->belongsTo(Rawproducts::class, 'product', 'id');
    }


}
