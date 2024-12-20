<?php

namespace App\Http\Controllers;

use App\Models\FinProductInHisExt;
use App\Models\FinproductInHisInt;
use App\Models\ProductStOutExtMap;
use App\Models\ProductStOutIntMap;
use App\Models\RawProductAdjHisExt;
use App\Models\RawProductAdjHisInt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class StkInControler extends Controller
{
    public function indexint()
    {

        $fp = new FinishproductController();
        $lp = $fp ->getfp() ;

        return view('process.assin.index', [
        "type" => 'int',
        "lp"=> $lp


    ]);


 }
 public function indexext()
    {

        $fp = new FinishproductController();
        $lp = $fp ->getfp() ;

        return view('process.assin.index', [
        "type" => 'ext',
        "lp"=> $lp


    ]);
}

 public function adjint(Request $request){
    $products = [];
    // Log::info('Products array:', [$request -> product]);
    // Log::info( $request);

    for ($i = 0; $i < count($request->product); $i++) {
        if (isset($request->product[$i]['rid']) && isset($request->product[$i]['quantity'])) {
            $products[] = [
                'product_id' => $request->product[$i]['id'],
                'quantity' => $request->product[$i]['quantity'],
                'rid' => $request->product[$i]['rid'],
                'remarks' => $request->product[$i]['remarks'] ?? null // Handle remarks if available
            ];
        }
    }


    // Filter out products with null quantity
    $products = array_filter($products, function($product) {
        return $product['quantity'] !== null;
    });


    // Log::info('Products array:', [ $products]);

    DB::transaction(function () use ($request, $products) {
        $sequence = DB::table('secuence')
        ->select('sno', 'head')
        ->where('type', 'stlintin')
        ->lockForUpdate()
        ->first();

        $head =  $sequence->head ;
        $newStkId = $sequence->sno + 1;
        $newStkId = str_pad($newStkId, 4, '0', STR_PAD_LEFT);
        $newStkId =  $head . '/' . $newStkId ;
        foreach ($products as $product) {


            ProductStOutIntMap::adjustProductint($product);

            RawProductAdjHisInt::create(
                [
                'id' => $newStkId,
                'from' => $request ->asid,
                'product'=> $product['product_id'],
                'qty'=> $product['quantity'],
                'remarks' => $product['remarks'],
                'entry_by' => Auth::user()->id,
                'date' => $request ->date,
                ]
                );
            }
        DB::table('secuence')
        ->where('type', 'stlintin')
        ->increment('sno');
    });

 }

 public function finProdInt(Request $request){
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


            DB::transaction(function () use ($request, $products) {

                $sequence = DB::table('secuence')
                ->select('sno', 'head')
                ->where('type', 'fstlintin')
                ->lockForUpdate()
                ->first();

                $head =  $sequence->head ;
                $newStkId = $sequence->sno + 1;
                $newStkId = str_pad($newStkId, 4, '0', STR_PAD_LEFT);
                $newStkId =  $head . '/' . $newStkId ;
                $rp= new FinishproductController();

                foreach ($products as $product) {

                    $rp->stkin($product['product_id'], $product['quantity']) ;

                FinproductInHisInt::create(
                    [
                        'id' => $newStkId,
                        'date' => $request ->date,
                        'aid' => $request ->asidi,
                        'product'=> $product['product_id'],
                        'qty'=> $product['quantity']
                    ]
                    );


                }
                    DB::table('secuence')
                    ->where('type', 'fstlintin')
                    ->increment('sno');
            });

}
public function adjext(Request $request){

    $products = [];
    // Log::info('Products array:', [$request -> product]);
    // Log::info( $request);

    for ($i = 0; $i < count($request->product); $i++) {
        if (isset($request->product[$i]['rid']) && isset($request->product[$i]['quantity'])) {
            $products[] = [
                'product_id' => $request->product[$i]['id'],
                'quantity' => $request->product[$i]['quantity'],
                'rid' => $request->product[$i]['rid'],
                'remarks' => $request->product[$i]['remarks'] ?? null // Handle remarks if available
            ];
        }
    }


    // Filter out products with null quantity
    $products = array_filter($products, function($product) {
        return $product['quantity'] !== null;
    });



    DB::transaction(function () use ($request, $products) {
        $sequence = DB::table('secuence')
        ->select('sno', 'head')
        ->where('type', 'stlextit')
        ->lockForUpdate()
        ->first();

        $head =  $sequence->head ;
        $newStkId = $sequence->sno + 1;
        $newStkId = str_pad($newStkId, 4, '0', STR_PAD_LEFT);
        $newStkId =  $head . '/' . $newStkId ;
        foreach ($products as $product) {

            ProductStOutExtMap::adjustProductext($product);

            RawProductAdjHisExt::create(
                [
                'id' => $newStkId,
                'from' => $request ->asid,
                'product'=> $product['product_id'],
                'qty'=> $product['quantity'],
                'remarks' => $product['remarks'],
                'entry_by' => Auth::user()->id,
                'date' => $request ->date,
                ]
                );

        }


     DB::table('secuence')
        ->where('type', 'stlextit')
        ->increment('sno');
    });
}

public function finProdExt(Request $request){

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

    DB::transaction(function () use ($request, $products) {

        $sequence = DB::table('secuence')
        ->select('sno', 'head')
        ->where('type', 'fstlextin')
        ->lockForUpdate()
        ->first();
        $head =  $sequence->head ;
        $newStkId = $sequence->sno + 1;
        $newStkId = str_pad($newStkId, 4, '0', STR_PAD_LEFT);
        $newStkId =  $head . '/' . $newStkId ;
        $rp= new FinishproductController();



        foreach ($products as $product) {

            $rp->stkin($product['product_id'], $product['quantity']) ;

        FinProductInHisExt::create(
            [
                'id' => $newStkId,
                'date' => $request ->date,
                'aid' => $request ->asidi,
                'product'=> $product['product_id'],
                'qty'=> $product['quantity']
            ]
            );

        }

        DB::table('secuence')
        ->where('type', 'fstlextin')
        ->increment('sno');

    });

}

}
