<?php

namespace App\Http\Controllers;

use App\Models\Assoint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class AssociateIntController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Assoint::select(['id', 'name', 'mobile', 'email', 'address', 'uidtype', 'uid','status'])  ;
            if (Auth::user()->role !== 'AD') {
                $data->where('status', 1);
            }
            $data -> orderBy('created_at', 'desc');

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    return view('admin.assoint.action', compact('row'));
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('admin.assoint.index');
    }

    public function store(Request $request)
    {
        $msg = "";
        $purpose = $request->purpose;
        if ($purpose == 'insert') {
            $request->validate([
                'name' => 'required',
                'mobile' => 'required|numeric|digits:10|unique:asso_int,mobile'
            ], [
                'mobile.unique' => 'The mobile number you entered is already added.'
            ]);

            DB::transaction(function () use ($request) {

            $sequence = DB::table('secuence')
            ->select('sno', 'head')
            ->where('type', 'asso_int')
            ->lockForUpdate()
            ->first();


            // Calculate new  ID
            $head =  $sequence->head ;
            $newId = $sequence->sno + 1;
            $newId = str_pad($newId, 3, '0', STR_PAD_LEFT);
            $newId =  $head . '_' . $newId ;
            Assoint::create([
                'id' => $newId,
                'name' => $request->name,
                'email' => $request->email,
                'mobile' => $request->mobile,
                'address' => $request->address,
                'uidtype' => $request->uidtype,
                'uid' => $request->uid,
                'status' => '1',
                'created_by' => Auth::user()->id
            ]);
            DB::table('secuence')
                 ->where('type', 'asso_int')
                 ->increment('sno');
                });

            $msg = "Successfully Associate created";

        } else if ($purpose == 'update') {
            $request->validate([
                'id' => 'required',
                // 'email' => 'required|string|email',
            ]);
            Assoint::where('id', $request->id)->update([

                'email' => $request->email,
                'address' => $request->address,
                'mobile' => $request->mobile,
                'name'  => $request->name,
            ]);
            $msg = "Successfully updated Associate";
        }

        return response()->json([
            "status" => true,
            "message" => $msg,
        ]);
    }
    public function edit(Request $request)
    {
        $user  = Assoint::select(['id', 'name', 'mobile', 'email',  'address'])->where(['id' => $request->id])->first();

        return response()->json($user);
    }
    public function disable(Request $request)
    {
        $user = Assoint::where('id', $request->id)->update([
            'status' => '0'
        ]

        );
        return Response()->json($user);

    }
    public function enable(Request $request)
    {
        $user = Assoint::where('id', $request->id)->update([
            'status' => '1'
        ]

        );
        return Response()->json($user);

    }


    public function getia(Request $request)
    {

        $user  = Assoint::select(['id as clid', 'name as name',  'mobile', 'address'])
        ->where(['mobile' => $request->mobile])->get();


        return response()->json($user);
    }
    public function getiabyname(Request $request)
    {

        $user = Assoint::select(['id as clid', 'name as name',  'mobile', 'address'])
        ->where('name', 'like', '%' . $request->name . '%')
        ->get();

        return response()->json($user);
    }
}
