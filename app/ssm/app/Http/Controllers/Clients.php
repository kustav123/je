<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables as DataTables;

class Clients extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {

            $data = Client::select(['id as userId', 'name', 'email', 'mobile', 'mobile_additonal', 'address', 'status', 'due_ammount', 'gst',  'remarks', 'created_by', 'created_at']);
            if (Auth::user()->role !== 'AD') {
                $data->where('status', 1);
            }

            $data->orderBy('created_at', 'desc');

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    return view('admin.client.action', compact('row'));
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        $centeredText = 'Client Contol Panel ';

        return view('admin.client.index',  compact('centeredText'));
    }

    public function store(Request $request)
    {
        $msg = "";
        $purpose = $request->purpose;
        if ($purpose == 'insert') {
            $request->validate([
                'name' => 'required',
                'mobile' => 'required|numeric|digits:10|unique:client,mobile',
            ], [
                'mobile.unique' => 'The mobile number you entered is already added as client.',
            ]);

            $sequence = DB::table('secuence')
            ->select('sno', 'head')
            ->where('type', 'client')
            ->lockForUpdate()
            ->first();

            $head =  $sequence->head ;
            $newclid = $sequence->sno + 1;
            $newclid = str_pad($newclid, 5, '0', STR_PAD_LEFT);
            $newclid =  $head . '-' . $newclid ;

            //secunce code ta ure geche
            Client::create([
                'id' => $newclid,
                'name' => $request->name,
                'email' => $request->email,
                'mobile' => $request->mobile,
                'mobile_additonal' => $request->mobile_additonal,
                'address' => $request->address,
                'gst' => $request->gst,
                'remarks' => $request->remarks,
                'status' => '1',
                'created_by' => Auth::user()->id,
            ]);
            DB::table('secuence')
                 ->where('type', 'client')
                 ->increment('sno');
            $msg = "Successfully client created";
            Cache::forget('act_users');
            Cache::forget('total_client');
            // Cache::forget('client_main');


        } else if ($purpose == 'update') {
            $request->validate([
                'id' => 'required',
                // 'email' => 'required|string|email',
            ]);
            Client::where('id', $request->id)->update([
                'name' => $request->name,
                'email' => $request->email,
                'address' => $request->address,
                'gst' => $request->gst,
                'remarks' => $request->remarks,
                'mobile_additonal' => $request->mobile_additonal,

            ]);
            $msg = "Successfully updated client";
        }

        return response()->json([
            "status" => true,
            "message" => $msg,
        ]);
    }

    public function edit(Request $request)
    {
        $user = Client::select(['id as userId', 'name', 'email', 'mobile', 'mobile_additonal', 'address', 'gst', 'job'])->where(['id' => $request->id])->first();

        return response()->json($user);
    }

    // public function destroy(Request $request)
    // {
    //     $user = Client::where('id', $request->id)->delete();

    //     return Response()->json($user);
    // }
    public function disable(Request $request)
    {
        $user = Client::where('id', $request->id)->update([
            'status' => '0',

        ]

        );
        Cache::forget('act_users');
        Cache::forget('total_client');
        return Response()->json($user);

    }
    public function enable(Request $request)
    {
        $user = Client::where('id', $request->id)->update([
            'status' => '1',

        ]

        );
        Cache::forget('act_users');
        Cache::forget('total_client');
        return Response()->json($user);

    }
    public function getcl(Request $request)
    {

        $user = Client::select(['id as clid', 'name', 'email', 'mobile', 'mobile_additonal', 'address', 'gst', 'due_ammount', 'remarks'])
            ->where(['mobile' => $request->mobile])
            ->get();
        if ($user->isEmpty()) {
            return response()->json(['message' => 'ClientNotFound'], 404);
        }
        return response()->json($user);
    }
    public function getclbyname(Request $request)
    {

        $user = Client::select(['id as clid', 'name', 'email', 'mobile', 'mobile_additonal', 'address', 'gst', 'due_ammount', 'remarks'])
            ->where('name', 'like', '%' . $request->name . '%')
            ->get();
        if ($user->isEmpty()) {
            return response()->json(['message' => 'ClientNotFound'], 404);
        }
        return response()->json($user);
    }
    public function getclid($id)
    {
        $user = Client::select(['name', 'email', 'mobile', 'mobile_additonal', 'address', 'gst'])
            ->where(['id' => $id])
            ->first();

        return $user;
    }
}
