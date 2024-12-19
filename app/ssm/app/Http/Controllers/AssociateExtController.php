<?php

namespace App\Http\Controllers;

use App\Models\Assoext;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\DataTables;

class AssociateExtController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Assoext::select(['id', 'name', 'mobile', 'email', 'status', 'address', 'uidtype', 'uid']) ;
            if (Auth::user()->role !== 'AD') {
                $data->where('status', 1);
            }
            $data -> orderBy('created_at', 'desc');

            // Log::info('SQL Query: ' . $data->toSql());
            // Log::info('Bindings: ' . json_encode($data->getBindings()));

            // // Execute the query and get the results
            // $results = $data->get();

            // // Optionally, log the results (be careful with large data)
            // Log::info('Query Results: ' . $results);
               return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    return view('admin.assoext.action', compact('row'));
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('admin.assoext.index');
    }

    public function store(Request $request)
    {
        $msg = "";
        $purpose = $request->purpose;
        if ($purpose == 'insert') {
            $request->validate([
                'name' => 'required',
                'mobile' => 'required|numeric|digits:10|unique:asso_ext,mobile'
            ], [
                'mobile.unique' => 'The mobile number you entered is already added .'
            ]);

            DB::transaction(function () use ($request) {

            $sequence = DB::table('secuence')
            ->select('sno', 'head')
            ->where('type', 'asso_ext')
            ->lockForUpdate()
            ->first();


            // Calculate new  ID
            $head =  $sequence->head ;
            $newId = $sequence->sno + 1;
            $newId = str_pad($newId, 3, '0', STR_PAD_LEFT);
            $newId =  $head . '_' . $newId ;
            Assoext::create([
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
                 ->where('type', 'asso_ext')
                 ->increment('sno');
                });

            $msg = "Successfully Associate created";

        } else if ($purpose == 'update') {
            $request->validate([
                'id' => 'required',
                // 'email' => 'required|string|email',
            ]);
            Assoext::where('id', $request->id)->update([

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
        $user  = Assoext::select(['id', 'name', 'mobile', 'email',  'address'])->where(['id' => $request->id])->first();

        return response()->json($user);
    }
    public function disable(Request $request)
    {
        $user = Assoext::where('id', $request->id)->update([
            'status' => '0'
        ]

        );
        return Response()->json($user);

    }
    public function enable(Request $request)
    {
        $user = Assoext::where('id', $request->id)->update([
            'status' => '1'
        ]

        );
        return Response()->json($user);

    }



    public function getea(Request $request)
    {

        $user  = Assoext::select(['id as clid', 'name', 'address','email', 'mobile'])
        ->where(['mobile' => $request->mobile])
        ->get();

        if (!$user) {
            return response()->json(['message' => 'ClientNotFound'], 404);
        }
        return response()->json($user);
    }
    public function geteabyname(Request $request)
    {

        $user = Assoext::select(['id as clid', 'name', 'address','email', 'mobile'])
        ->where('name', 'like', '%' . $request->name . '%')
        ->get();
        if (!$user) {
            return response()->json(['message' => 'ClientNotFound'], 404);
        }
        return response()->json($user);
    }

}
