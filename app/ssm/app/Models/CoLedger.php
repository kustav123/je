<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class CoLedger extends Model
{
    use HasFactory;
    protected $table = 'comp_leadger';
    protected $primaryKey = 'id';

    // Specify if the IDs are auto-incrementing
    public $incrementing = true;

    // Specify if the model should be timestamped
    public $timestamps = true;

    // Specify the attributes that are mass assignable
    protected $fillable = [
        'comp_id',
        'clid',
        'clname',
        'date',
        'type',
        'current_amount',
        'trans_amount',
        'mode',
        'remarks',
        'refno',
        'tid',
        'created_at',
    ];

    public static function fetchByCompidByDate($coid, $from, $to)
    {
        // Fetch the records as a collection
        $records = self::where('comp_id', $coid)
            ->whereBetween('date', [$from, $to])
            ->orderBy('date', 'asc' )
            ->get(); // Use get() to retrieve the collection

            $records->transform(function ($record) {
                $record->credit = ($record->type === 'pay') ? null : $record->trans_amount;
                $record->debit = ($record->type === 'pay') ? $record->trans_amount : null;

                return $record;
            });

        return $records;
    }

    public static function  addent ($id,$clid,$clname,$type,$date,$ammount,$mode,$refno,$entid,$trid)
    {

    $cur=DB::table('appinfo')
        ->select('due_ammount')
        ->where('id', $id)
        ->first();


     self::create([
            'comp_id' => $id,
            'clid' => $clid,
            'clname' => $clname,
            'date' => $date,
            'tid' => $trid,
            'type' => $type,
            'trans_amount' => $ammount,
            'current_amount' => $cur -> due_ammount,
            'mode' => $mode,
            'refno' => $refno,
            'remarks' => $entid,


        ]);
    }
}
