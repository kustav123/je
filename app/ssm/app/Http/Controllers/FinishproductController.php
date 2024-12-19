<?php

namespace App\Http\Controllers;

use App\Models\Finishproducts;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\DataTables;
class FinishproductController extends Controller
{
    public function index(Request $request)
    {

        if ($request->ajax()) {


            $data = Finishproducts::select([
                'id as fid',
                'name',
                'unit',
                'current_stock',
                'remarks',
                'status',
            ]);
            if (Auth::user()->role !== 'AD') {
                $data->where('status', 1);
            }
            $data -> orderBy('name');

            return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                return view('inv.finish.action', compact('row'));
            })
            ->rawColumns(['action'])
            ->make(true);

    }

    return view('inv.finish.index');
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
            ->where('type', 'fp')
            ->lockForUpdate()
            ->first();
            $head =  $sequence->head ;
            $newJobId = $sequence->sno + 1;
            $newJobId = str_pad($newJobId, 3, '0', STR_PAD_LEFT);
            $newJobId =  $head . '_' . $newJobId ;

            DB::transaction(function () use ($request, $newJobId) {

          Finishproducts::create([
              'id' => $newJobId,
              'name' => $request->name,
              'unit' => $request->unit,
              'remarks' => $request -> remarks,
              'status' => '1',
              'created_by' => Auth::user()->id

            ]);
            DB::table('secuence')
            ->where('type', 'fp')
            ->increment('sno');
            });
            Cache::forget('finprod' );

            $msg = "Successfully Product created";

      } else if ($purpose == 'update') {
          $request->validate([
              'id' => 'required',
              // 'email' => 'required|string|email',

          ]);
        //   Log::info('User data fetched:', ['user' => $request->id]);

          Finishproducts::where('id', $request->id)->update([
              'remarks' => $request->remarks,
          ]);
          Cache::forget('finprod' );

          $msg = "Successfully  products updated";
      }

      return response()->json([
          "status" => true,
          "message" => $msg,
      ]);
  }
  public function edit(Request $request)
  {


      $user  = Finishproducts::select([

        'id as fid',
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
      $user = Finishproducts::where('id', $request->id)->update([
          'status' => '0'

      ]

      );
      Cache::forget('finprod' );

      return Response()->json($user);

  }
  public function enable(Request $request)
  {
      $user = Finishproducts::where('id', $request->id)->update([
          'status' => '1'

      ]

      );
      Cache::forget('finprod' );

      return Response()->json($user);

  }

  public function getfp()
    {
        $item = Cache::rememberForever('finprod', function () {
        return Finishproducts::select([
            'id', 'name', 'unit'
            ])->where('status',1) ->get();
        });
        return $item;
    }

    public function stkin($id,$qty)
    {
        $product = Finishproducts::find($id);

            $newStock = $product->current_stock + $qty;

            $product->update(['current_stock' => $newStock]);
    }
}

