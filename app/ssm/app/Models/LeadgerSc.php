<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeadgerSc extends Model
{
    use HasFactory;
    protected $table = 'leadger_sc';
    const UPDATED_AT = NULL ;

    protected $fillable = [
        'clid',
        'date',
        'type',
        'tid',
        'current_amomount',
        'truns_ammount',
        'mode',
        'remarks',
        'refno',
        'created_at',
    ];


    public static function fetchByClid($clid)
    {
        $records = self::where('clid', $clid)
        ->orderBy('created_at', 'desc')
        ->paginate(10);


        $records->getCollection()->transform(function ($record) {
        $record->credit = ($record->type === 'pay') ? null : $record->truns_ammount;
        $record->debit = ($record->type === 'pay') ? $record->truns_ammount : null;
        $record->narration = ($record->type === 'pay')
            ? 'Paid Via ' . $record->remarks
            : 'Credit Via ' . $record->remarks;


        return $record;
        });

        return $records;
    }
}
