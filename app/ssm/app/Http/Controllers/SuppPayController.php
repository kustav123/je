<?php

namespace App\Http\Controllers;

use App\Models\SuppPay;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SuppPayController extends Controller
{
    public function addnewPage()

    {
        $appinfo = new AppinfoController();
        $listcomp = $appinfo ->getlist();
        // Log::info("", $listcomp);
         return view("fin.addSupPay", [
        'listcomp' => $listcomp
        ]);
    }

    public function pay(Request $request)

    {
        // Log::info($request);

        // Filter nulled one

        $sequence = DB::table('secuence')
        ->select('sno', 'head')
        ->where('type', 'paysup')
        ->lockForUpdate()
        ->first();


        // Calculate new job ID
        $head =  $sequence->head ;
        $newJobId = $sequence->sno + 1;
        $newJobId = str_pad($newJobId, 5, '0', STR_PAD_LEFT);
        $newJobId =  $head . '/' . $newJobId ;

        DB::transaction(function () use ($request, $newJobId) {
        $curamount = $request->due_amount - $request->amount;

           SuppPay::create([
            'id' => $newJobId,
            'scid' => $request -> clid,
            'amount' => $request -> amount,
            'mode' => $request -> mode,
            'hisamount' => $request -> due_amount,
            'curamount' => $curamount,
            'remarks' => $request -> comment,
            'frmaccount' => $request -> refAccontNo,
            'frmbnk' => $request -> bank,
            'created_by' => Auth::user()->id,
            'trid' => $request -> tid,
            'compid' => $request -> select_company

           ]);

            DB::table('secuence')
            ->where('type', 'paysup')
            ->increment('sno');
            $du= new SupplierController();
            $du->updatedue( $request -> clid, $request -> amount, 'pay');

            $ledg = new scLedgerController();
            $ledg->addent($request -> clid, 'pay', $request -> datePicker, $request -> amount,  $request -> mode, ' ', $newJobId,$request -> tid);

        });
        $appinfo = new AppinfoController();
        $getcomp = $appinfo->byid($request->select_company) ;
        // $msg = "Successfully updated payment from $request->name against $newJobId " ;
        return response()->json([
            "status" => true,
            'Jobid' => $newJobId,
            'Name' => $request->name,
            'CompName' => $getcomp->cname,
            'CompLogo' => $getcomp->logo,
            'CompAddress' => $getcomp->address,
            'CompGST' => $getcomp->gstno,
            'Compemail' => $getcomp->email,
            'Compcont1' => $getcomp->cont1,
            'Compcont2' => $getcomp->cont2,
            'amount' => $request -> amount,
            'scid' => $request -> clid,
            'mode' => $request -> mode,
            'remarks' => $request -> comment


        ]);
    }


}
