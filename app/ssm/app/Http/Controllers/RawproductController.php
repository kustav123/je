<?php

namespace App\Http\Controllers;

use App\Models\Rawproducts;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\DataTables;

class RawproductController extends Controller
{
    public function index(Request $request)
    {

        if ($request->ajax()) {

            $data = Rawproducts::select([
                'id as rid',
                'name',
                'unit',
                'current_stock',
                'remarks',
                'status'
            ]);
            if (Auth::user()->role !== 'AD') {
                $data->where('status', 1);
            }
            // Log::info('User data fetched:', ['data' => $data->toSql()]); // Log SQL query
            $data -> orderBy('name');

            return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                return view('inv.raw.action', compact('row'));
            })
            ->rawColumns(['action'])
            ->make(true);

    }
    $centeredText = 'Raw Product Management';

    return view('inv.raw.index',  compact('centeredText'));
}

  public function store(Request $request)
  {
      $msg = "";
      $purpose = $request->purpose;
      if ($purpose == 'insert') {
          $request->validate([
              'name' => 'required',
              'unit' => 'required'
            ]);


            $sequence = DB::table('secuence')
            ->select('sno', 'head')
            ->where('type', 'rp')
            ->lockForUpdate()
            ->first();
            $head =  $sequence->head ;
            $newJobId = $sequence->sno + 1;
            $newJobId = str_pad($newJobId, 3, '0', STR_PAD_LEFT);
            $newJobId =  $head . '_' . $newJobId ;
            // Log::info('New Job ID: ' . $newJobId);
            // Log::info( $request->complain);

        DB::transaction(function () use ($request, $newJobId) {
          Rawproducts::create([
              'id' => $newJobId,
              'name' => $request->name,
              'unit' => $request->unit,
              'remarks' => $request -> remarks,
              'status' => '1',
              'created_by' => Auth::user()->id

          ]);
          DB::table('secuence')
          ->where('type', 'rp')
          ->increment('sno');
        });
          $msg = "Successfully products created";

      } else if ($purpose == 'update') {
          $request->validate([
              'id' => 'required',
              // 'email' => 'required|string|email',

          ]);
        //   Log::info('User data fetched:', ['user' => $request->id]);

          Rawproducts::where('id', $request->id)->update([
              'remarks' => $request->remarks,
          ]);
          $msg = "Successfully  products updated";
      }
      Cache::forget('rawprod' );

      return response()->json([
          "status" => true,
          "message" => $msg,
      ]);
  }


  public function edit(Request $request)
  {


      $user  = Rawproducts::select([

        'id as rid',
        'name',
        'unit',
        'remarks'

        ])->where(['id' => $request->id]
      )->first();
    //   Log::info($user);


      return response()->json($user);
  }

  public function disable(Request $request)
  {
      $user = Rawproducts::where('id', $request->id)->update([
          'status' => '0'
      ]
      );
      Cache::forget('rawprod' );


      return Response()->json($user);

  }
  public function enable(Request $request)
  {
      $user = Rawproducts::where('id', $request->id)->update([
          'status' => '1'
      ]
      );
      Cache::forget('rawprod' );


      return Response()->json($user);

  }
  public function getrp()
    {
        $item=Rawproducts::select([
            'id', 'name', 'unit', 'current_stock'
            ])->where('status',1) ->get();

        return $item;
    }

    public function stkin($id,$qty)
    {
        $product = Rawproducts::find($id);

            $newStock = $product->current_stock + $qty;

            $product->update(['current_stock' => $newStock]);
    }
    public function stkout($id,$qty)
    {
        $product = Rawproducts::find($id);

            $newStock = $product->current_stock - $qty;

            $product->update(['current_stock' => $newStock]);
    }
}
