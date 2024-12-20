<?php

namespace App\Http\Controllers;

use App\Models\LeadgerSc;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class scLedgerController extends Controller
{

    public function addent ($id,$type,$date,$ammount,$mode,$refno,$entid,$trid)
    {

    $cur=DB::table('supplier')
        ->select('due_ammount')
        ->where('id', $id)
        ->first();


     LeadgerSc::create([
            'clid' => $id,
            'date' => $date,
            'tid' => $trid,
            'type' => $type,
            'truns_ammount' => $ammount,
            'current_amomount' => $cur -> due_ammount,
            'mode' => $mode,
            'refno' => $refno,
            'remarks' => $entid


        ]);
    }

    public function fetchByClid(Request $request)
    {
        $request->validate([
            'clid' => 'required'
        ]);

        $clid = $request->input('clid');
        $page = $request->input('page', 1);


        $records = LeadgerSc::fetchByClid($clid );

        // Log::info($records);
        $centeredText = 'Supplier Ledger ';


        return view('report.supLed', ['records' => $records, 'centeredText' => $centeredText, ]);
    }
}
