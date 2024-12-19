<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class ClientLeadger extends Model
{
    use HasFactory;
    protected $table = 'client_leadger';

    // Define the primary key
    protected $primaryKey = 'id';

    // Specify if the IDs are auto-incrementing
    public $incrementing = true;
    const UPDATED_AT = null;

    // Specify if the model should be timestamped
    public $timestamps = true;

    // Specify the attributes that are mass assignable
    protected $fillable = [
        'clid',
        'date',
        'type',
        'current_amount',
        'trans_amount',
        'mode',
        'remarks',
        'refno',
        'tid',
        'created_at',
        'comp_id'
    ];

    // Specify the attributes that should be cast to native types

    public function Client()
    {
        return $this->belongsTo(Client::class, 'clid', 'id');
    }
    public static function fetchByClid($clid)
    {
        $records = self::where('clid', $clid)
        ->orderBy('created_at', 'desc')
        ->paginate(12);


        $records->getCollection()->transform(function ($record) {
        $record->credit = ($record->type === 'pay') ? null : $record->trans_amount;
        $record->debit = ($record->type === 'pay') ? $record->trans_amount : null;



        return $record;
        });

        return $records;
    }


    public static function fetchByClidByDate($clid, $from, $to)
    {
        // Fetch the records as a collection
        $records = self::where('clid', $clid)
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


    public static function  addent ($id,$type,$date,$ammount,$mode,$refno,$entid,$trid,$comp)
    {

    $cur=DB::table('client')
        ->select('due_ammount')
        ->where('id', $id)
        ->first();


     self::create([
            'clid' => $id,
            'date' => $date,
            'tid' => $trid,
            'type' => $type,
            'trans_amount' => $ammount,
            'current_amount' => $cur -> due_ammount,
            'mode' => $mode,
            'refno' => $refno,
            'remarks' => $entid,
            'comp_id' => $comp


        ]);
    }

}
