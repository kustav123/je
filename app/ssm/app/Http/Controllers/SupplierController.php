<?php

namespace App\Http\Controllers;

use App\Models\ProductEntryHist;
use App\Models\ProductEntryMain;
use App\Models\Suppliers;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\DataTables;

class SupplierController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Suppliers::select([
                'id as sid',
                'merchant_name',
                'mobile',
                'email',
                'address',
                'due_ammount',
                'gst',
                'remarks',
                'status',
            ]);
             if (Auth::user()->role !== 'AD') {
                $data->where('status', 1);
            }
            $data -> orderBy('merchant_name');

            return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                return view('admin.supplier.action', compact('row'));
            })
            ->rawColumns(['action'])
            ->make(true);
    }
    return view('admin.supplier.index');
  }

  public function store(Request $request)
  {
      $msg = "";
      $purpose = $request->purpose;
      if ($purpose == 'insert') {
          $request->validate([
              'name' => 'required',
              'mobile' => 'required|numeric|digits:10|unique:supplier,mobile'
          ], [
              'mobile.unique' => 'The mobile number you entered is already added as supplier.'
          ]);

          $sequence = DB::table('secuence')
          ->select('sno', 'head')
          ->where('type', 'supplier')
          ->lockForUpdate()
          ->first();
          $head =  $sequence->head ;
          $newclid = $sequence->sno + 1;
          $newclid = str_pad($newclid, 5, '0', STR_PAD_LEFT);
          $newclid =  $head . '-' . $newclid ;

          Suppliers::create([
              'id' =>$newclid,
              'merchant_name' => $request->name,
              'email' => $request->email,
              'mobile' => $request->mobile,
              'address' => $request->address,
              'gst' => $request->gst,
              'remarks' => $request->remarks,
              'status' => '1',
              'created_by' => Auth::user()->id
          ]);
          DB::table('secuence')
          ->where('type', 'supplier')
          ->increment('sno');
          $msg = "Successfully supplier created";

      } else if ($purpose == 'update') {
          $request->validate([
              'id' => 'required',
              // 'email' => 'required|string|email',

          ]);
        //   Log::info('User data fetched:', ['user' => $request->id]);

          Suppliers::where('id', $request->id)->update([
              'merchant_name' => $request->name,
              'email' => $request->email,
              'address' => $request->address,
              'gst' => $request->gst,
              'remarks' => $request->remarks,
          ]);
          $msg = "Successfully updated supplier";
      }

      return response()->json([
          "status" => true,
          "message" => $msg,
      ]);
  }

  public function edit(Request $request)
  {


      $user  = Suppliers::select([

            'id as sid',
            'merchant_name',
            'mobile',
            'email',
            'address',
            'gst',
            'remarks'

        ])->where(['id' => $request->id]
      )->first();
    //   Log::info($user);


      return response()->json($user);
  }

  // public function destroy(Request $request)
  // {
  //     $user = Client::where('id', $request->id)->delete();

  //     return Response()->json($user);
  // }
  public function disable(Request $request)
  {
      $user = Suppliers::where('id', $request->id)->update([
          'status' => '0'

      ]

      );

      return Response()->json($user);
  }
  public function enable(Request $request)
  {
      $user = Suppliers::where('id', $request->id)->update([
          'status' => '1'

      ]

      );

      return Response()->json($user);
  }
  public function getsl(Request $request)
    {

        $user  = Suppliers::select(['id as clid', 'merchant_name as name', 'email', 'mobile', 'address','gst', 'due_ammount', 'remarks'])
        ->where(['mobile' => $request->mobile])->get();

        if (!$user) {
            return response()->json(['message' => 'ClientNotFound'], 404);
        }
        return response()->json($user);
    }
    public function getslbyname(Request $request)
    {

        $user = Suppliers::select(['id as clid', 'merchant_name as name', 'email', 'mobile', 'address', 'gst', 'due_ammount', 'remarks'])
        ->where('merchant_name', 'like', '%' . $request->name . '%')
        ->get();
        if (!$user) {
            return response()->json(['message' => 'ClientNotFound'], 404);
        }
        return response()->json($user);
    }



    public function updatedue($id,$due,$type)
    {
        $cl = Suppliers::find($id);

        if ($type == 'due'){
            $newdue = $cl->due_ammount + $due;
        } else {
            // Log::info($due);

            $newdue = $cl->due_ammount - $due;
            // Log::info($newdue);
        }
        $cl->update(['due_ammount' => $newdue]);
    }
    public function getbyproduct(Request $request)
    {


        // Log::info($request -> id);
        $supplierQty = ProductEntryHist::query()
        ->where('product', $request -> clid)
        ->join('product_entry_main', 'product_entry_history.entry_id', '=', 'product_entry_main.id')
        ->join('supplier', 'product_entry_main.from', '=', 'supplier.id')
        ->select(
            'product_entry_main.id',
            'supplier.merchant_name',
            'product_entry_history.qty',
            'product_entry_main.created_at'
        )
        ->get()
        ->map(function ($record) {
            return [
                'id' => $record->id,
                'merchant_name' => $record->merchant_name,
                'qty' => $record->qty,
                'created_at' => Carbon::parse($record->created_at)->format('Y-m-d H:i:s') // Format date after retrieval
            ];
        });
        return DataTables::of($supplierQty)
        ->addIndexColumn()
        ->addColumn('action', function ($row) {
            return view('inv.raw.actionlsit', ['row' => $row]);
        })
        ->rawColumns(['action'])
        ->make(true);

    }

    }



