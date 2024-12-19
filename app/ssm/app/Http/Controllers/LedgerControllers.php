<?php

namespace App\Http\Controllers;


use App\Models\Client;
use App\Models\ClientLeadger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class LedgerControllers extends Controller
{

    public function fetchByClid(Request $request)
    {
        $request->validate([
            'clid' => 'required'
        ]);


        $clid = $request->input('clid');
        $page = $request->input( 'page', 1);

        $records = ClientLeadger::fetchByClid($clid );

        $name= Client::getname($clid );
        $centeredText = 'Client Ledger for ' . $name;
        // Log::info($records);

        return view('report.cliLed', ['name' => $name,'records' => $records,
        'centeredText' => $centeredText,
        'clid' => $clid ]
       );
    }



}
