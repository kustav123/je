<?php

namespace App\Http\Controllers;

use App\Models\Hsn;
use App\Models\AuditLogModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Yajra\DataTables\DataTables;

class HsnController extends Controller
{
    public function index(Request $request)
    {

        if ($request->ajax()) {

        $data = Hsn::select(['id', 'name', 'cgst', 'sgst', 'status']);

            // Apply status filter based on user role
            if (Auth::user()->role !== 'AD') {
                $data->where('status', 1);
            }
            $data -> orderBy('name');


            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    return view('admin.hsn.action', compact('row'));
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        $centeredText = 'HSN/SAC Contol Panel ';

        return view('admin.hsn.index',  compact('centeredText'));
    }

    public function store(Request $request)
    {
        $msg = "";
        $purpose = $request->purpose;
        if ($purpose == 'insert') {
            $request->validate([
                'id' => 'required|unique:hsn,id',
            ], [
                'id.unique' => 'The ID you entered is already added.'
            ]);

            Hsn::create([
                'id' => $request->id,
                'name' => $request->name,
                'cgst' => $request-> cgst,
                'sgst' => $request->sgst,
                'status' => '1',
            ]);
            Cache::forget('hsn');
            $msg = "Successfully item created";
            AuditLogModel::addAudit(Auth::user()->id,
                        'HSN ',
                        "New HSN added  {$request->name} "
                    );
        } else if ($purpose == 'update') {
            $request->validate([
                'id' => 'required',
            ]);
            HSN::where('id', $request->id)->update([
                'name' => $request->name,
                'cgst' => $request-> cgst,
                'sgst' => $request->sgst,
            ]);
            AuditLogModel::addAudit(Auth::user()->id,
            'HSN ',
            "HSN {$request->name} Updated"
        );
            Cache::forget('hsn');
            $msg = "Successfully updated item";
        }

        return response()->json([
            "status" => true,
            "message" => $msg,
        ]);
    }

    public function edit(Request $request)
    {

        $user  = Hsn::select(['id', 'name'])->where(['id' => $request->id])->first();
        Cache::forget('hsn');

        return response()->json($user);
    }

    public function disable(Request $request)
    {
        $user = Hsn::where('id', $request->id)->update([
            'status' => '0'
        ]
        );
        AuditLogModel::addAudit(Auth::user()->id,
        'HSN ',
        "HSN {$request->id} Disabled"
    );
        Cache::forget('hsn');
        return Response()->json($user);
    }
    public function enable(Request $request)
    {
        $user = Hsn::where('id', $request->id)->update([
            'status' => '1'
        ]
        );
        AuditLogModel::addAudit(Auth::user()->id,
        'HSN ',
        "HSN {$request->id} Enabled"
    );
        Cache::forget('hsn');
        return Response()->json($user);
    }

}



