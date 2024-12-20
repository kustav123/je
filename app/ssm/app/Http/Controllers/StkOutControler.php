<?php

namespace App\Http\Controllers;

use App\Models\ProductStOutExt;
use App\Models\ProductStOutExtDtl;
use App\Models\ProductStOutExtMap;
use App\Models\ProductStOutInt;
use App\Models\ProductStOutIntDtl;
use App\Models\ProductStOutIntMap;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\DataTables;

class StkOutControler extends Controller
{
    public function indexint()
    {

        $rp = new RawproductController();
        $lp = $rp ->getrp() ;
        $centeredText = 'Raw Stock Trunsfer to Internal Associate';
log::info($lp);
        return view('process.assout.index', [
        "lp"=> $lp,
        "type" => 'int',
        "centeredText" => $centeredText,
    ]);
    }
    public function indexext()
    {

        $rp = new RawproductController();
        $lp = $rp ->getrp() ;
        $centeredText = 'Raw Stock Trunsfer to External Associate';

        return view('process.assout.index', [
        "lp"=> $lp,
        "type" => 'ext',
        "centeredText" => $centeredText,

    ]);
    }

    public function intoutstock(Request $request)
    {
        // Log::info($request);

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
        ->where('type', 'stkintout')
        ->lockForUpdate()
        ->first();

        $head =  $sequence->head ;
        $newStkId = $sequence->sno + 1;
        $newStkId = str_pad($newStkId, 4, '0', STR_PAD_LEFT);
        $newStkId =  $head . '/' . $newStkId ;

        DB::transaction(function () use ($request, $newStkId, $products) {

           ProductStOutInt::create([
            'id' => $newStkId,
            'to' => $request-> clid,
            'date' => $request -> datePicker,
            'entry_by' => Auth::user()->id,
            'remarks' => $request -> remarks
           ]);

           foreach ($products as $product) {
            ProductStOutIntDtl::create([
                'eid' => $newStkId,
                'product' => $product['product_id'],
                'qty' => $product['quantity'],
           ]);

            ProductStOutIntMap::updateOrInsertProduct($request-> clid, $product);

           $rp= new RawproductController();
           $rp->stkout($product['product_id'], $product['quantity']) ;
        }


        DB::table('secuence')
        ->where('type', 'stkintout')
        ->increment('sno');
    });

    $msg = "Successfully assigned stock to $request->name against $newStkId " ;
    return response()->json([
        "status" => true,
        "message" => $msg,
    ]);
    }


    public function extoutstock(Request $request)
    {
        // Log::info($request);

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
        ->where('type', 'stkextout')
        ->lockForUpdate()
        ->first();

        $head =  $sequence->head ;
        $newStkId = $sequence->sno + 1;
        $newStkId = str_pad($newStkId, 4, '0', STR_PAD_LEFT);
        $newStkId =  $head . '/' . $newStkId ;

        DB::transaction(function () use ($request, $newStkId, $products) {

           ProductStOutExt::create([
            'id' => $newStkId,
            'to' => $request-> clid,
            'date' => $request -> datePicker,
            'entry_by' => Auth::user()->id,
            'remarks' => $request -> remarks
           ]);

           foreach ($products as $product) {
            ProductStOutExtDtl::create([
                'eid' => $newStkId,
                'product' => $product['product_id'],
                'qty' => $product['quantity'],
           ]);

            ProductStOutExtMap::updateOrInsertProduct($request-> clid, $product);

           $rp= new RawproductController();
           $rp->stkout($product['product_id'], $product['quantity']) ;
        }


        DB::table('secuence')
        ->where('type', 'stkextout')
        ->increment('sno');
    });

    $msg = "Successfully assigned stock to $request->name against $newStkId " ;
    return response()->json([
        "status" => true,
        "message" => $msg,
    ]);
    }


    public function stockinhisint(Request $request){

    $product = $request -> pid;

    if ($request->ajax()) {

        $product = $request -> clid;

        // Log::info($product);

        $extData = ProductStOutExtDtl::with('productStOutExt.assoext')
        ->where('product', $product)
        ->get()
        ->map(function ($item) {
            return [
                'eid' => $item->eid,
                'asso_name' => $item->productStOutExt->assoext->name ?? 'N/A',
                'entry_time' => $item->productStOutExt->entry_time,
                'qty' => $item->qty,
            ];
        });

    // Fetch details from ProductStOutIntDtl
    $intData = ProductStOutIntDtl::with('productStOutInt.assoint')
        ->where('product', $product)
        ->get()
        ->map(function ($item) {
            return [
                'eid' => $item->eid,
                'asso_name' => $item->productStOutInt->assoint->name ?? 'N/A',
                'entry_time' => $item->productStOutInt->entry_time,
                'qty' => $item->qty,
            ];
        });

        if ($extData->isEmpty() ) {
            $data = $intData->merge($extData);;
        } elseif ($intData->isEmpty()) {
            $data = $extData->merge($intData);
        } else {
            $data = $intData->merge($extData);
        }

    // Combine the results

// Log::info($data);
        return DataTables::of($data)
        ->addIndexColumn()
        // ->addColumn('action', function ($row) {
        //     return view('process.assout.action', compact('row'));
        // })
        // ->rawColumns(['action'])
        ->make(true);
    }
    $centeredText = 'Product Transaction  History';
    return view('inv.raw.list', ['clid' => $product, 'centeredText' => $centeredText ]);
    }


    public function stockMapExt(Request $request){

            $id = $request -> id;


            $results = ProductStOutExtMap::with('rawProduct')
            ->where('aid', $id)
            ->get(['id as rid','qty', 'product']);

        // Transform the results to include the product name
            $data = $results->map(function ($item) {
            return [
            'product_name' => $item->rawProduct->name,
            'qty' => $item->qty,
            'unit' => $item->rawProduct->unit,
            'id'   => $item->product,
            'rid' => $item -> rid
            ];
            });

            return response()->json($data);
    }


    public function stockMapInt(Request $request){

        $id = $request -> id;


        $results = ProductStOutIntMap::with('rawProduct')
        ->where('aid', $id)
        ->get(['id as rid','qty', 'product']);

    // Transform the results to include the product name
        $data = $results->map(function ($item) {
        return [
        'product_name' => $item->rawProduct->name,
        'qty' => $item->qty,
        'unit' => $item->rawProduct->unit,
        'id'   => $item->product,
         'rid' => $item -> rid

        ];
        });

        return response()->json($data);
}
}
