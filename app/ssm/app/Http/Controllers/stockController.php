<?php

namespace App\Http\Controllers;

use App\Models\ProductEntryHist;
use App\Models\ProductEntryMain;
use App\Models\Rawproducts;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class stockController extends Controller
{
    public function addnewPage(Request $request)

    {
        $rp = new RawproductController();
        $lp = $rp ->getrp() ;
        // Log::info($lp);
        $centeredText = 'Raw Product Stock Entry';

       return view("inv.stkent.addStock", [
        "lp"=> $lp,
        "centeredText" => $centeredText


    ]);
    }

    public function stockentry(Request $request)

    {
        // Log::info($request);

        // Filter nulled one
        $products = [];
        for ($i = 0; $i < count($request->products); $i += 2) {
            if (isset($request->products[$i]['product_id']) && isset($request->products[$i + 1]['quantity'])) {
                $products[] = [
                    'product_id' => $request->products[$i]['product_id'],
                    'quantity' => $request->products[$i + 1]['quantity']
                ];
            }
        }

        $products = array_filter($products, function($product) {
            return $product['quantity'] !== null;
        });



        // Log::info(print_r($products, true));

        $sequence = DB::table('secuence')
        ->select('sno', 'head')
        ->where('type', 'stkent')
        ->lockForUpdate()
        ->first();


        // Calculate new job ID
        $head =  $sequence->head ;
        $newJobId = $sequence->sno + 1;
        $newJobId = str_pad($newJobId, 5, '0', STR_PAD_LEFT);
        $newJobId =  $head . '/' . $newJobId ;

        DB::transaction(function () use ($request, $newJobId, $products) {

           ProductEntryMain::create([
            'id' => $newJobId,
            'chalan_no' => $request->refInvoiceNo,
            'recived_date' => $request -> datePicker,
            'delivary_mode' => $request -> mode,
            'total_amount'  => $request -> totalAmount,
            'total_cgst' => $request -> totalCgst,
            'total_sgst'=> $request -> totalSgst,
            'remarks'=> $request -> remarks,
            'from' => $request -> clid,
            'created_by' => Auth::user()->id,
           ]);
           $rp= new RawproductController();
           foreach ($products as $product) {
                ProductEntryHist::create([
                    'entry_id' => $newJobId,
                    'product' => $product['product_id'],
                    'qty' => $product['quantity'],
                    // 'amount' => 0, // If you have amount details, include them here
                    // 'remarks' => '', // If you have remarks, include them here
                ]);
                $rp->stkin($product['product_id'], $product['quantity']) ;

            }
            DB::table('secuence')
            ->where('type', 'stkent')
            ->increment('sno');

            $du= new SupplierController();
            $du->updatedue( $request -> clid, $request -> totalAmount, 'due');

            $ledg = new scLedgerController();
            $ledg->addent($request -> clid, 'due', $request -> datePicker, $request -> totalAmount, 'Stock Entry', $request->refInvoiceNo, $newJobId,$request->refInvoiceNo);
        });

        $msg = "Successfully added stock from $request->name against $newJobId " ;
        return response()->json([
            "status" => true,
            "message" => $msg,
        ]);
    }

    public function stockhsit(Request $request) {

        $productEntries = ProductEntryHist::select('product_entry_history.*', 'raw_product.name')
        ->join('raw_product', 'product_entry_history.product', '=', 'raw_product.id')
        ->where('product_entry_history.entry_id', $request->id)
        ->get();
                return json_encode($productEntries);

    }

}
