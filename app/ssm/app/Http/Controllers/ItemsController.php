<?php

namespace App\Http\Controllers;
use Exception;
use App\Models\Items;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class ItemsController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Items::select(['id', 'name', 'accessary', 'complain', 'make', 'remarks', 'status', 'created_by', 'created_at']) ;
            if (Auth::user()->role !== 'AD') {
                $data->where('status', 1);
            }
            // ->where('status', '>', '1'); //Grater Than
            // ->where('status', '1'); //Equal to

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    return view('admin.items.action', compact('row'));
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        $centeredText = 'Job Item Contol Panel ';

        return view('admin.items.index',  compact('centeredText'));
    }

    public function store(Request $request)
    {
        $msg = "";
        $purpose = $request->purpose;
        if ($purpose == 'insert') {
            $request->validate([
                'name' => 'required|unique:item,name',
            ], [
                'name.unique' => 'The Name you entered is already added as Product.'
            ]);

            Items::create([
                'name' => $request->name,
                'accessary' => $request -> accessary,
                'complain' => $request -> complain,
                'make' => $request -> make,
                'remarks' => $request -> remarks,
                'status' => '1',
                'created_by' => Auth::user()->id
            ]);
            Cache::forget('itemlist');
            $msg = "Successfully item created";
        } else if ($purpose == 'update') {
            $request->validate([
                'id' => 'required',
            ]);
            Items::where('id', $request->id)->update([
                'accessary' => $request -> accessary,
                'complain' => $request -> complain,
                'make' => $request -> make,
                'remarks' => $request -> remarks,
            ]);
            Cache::forget('itemlist');
            $msg = "Successfully updated item";
        }

        return response()->json([
            "status" => true,
            "message" => $msg,
        ]);
    }

    public function edit(Request $request)
    {

        $user  = Items::select(['id', 'name', 'accessary', 'complain', 'make', 'remarks'])->where(['id' => $request->id])->first();

        return response()->json($user);
    }
    public function disable(Request $request)
    {
        $user = Items::where('id', $request->id)->update([
            'status' => '0'
        ]
        );
        Cache::forget('itemlist');
        return Response()->json($user);
    }
    public function enable(Request $request)
    {
        $user = Items::where('id', $request->id)->update([
            'status' => '1'
        ]
        );
        Cache::forget('itemlist');
        return Response()->json($user);
    }
    public function getitm(Request $request)
    {
        $item = Cache::rememberForever('itemlist', function () {
        return Items::select([
            'id as itmid', 'name', 'accessary', 'complain', 'make', 'remarks'
            ])->where('status',1)->get();
        });
        return response()->json($item);
    }
    public function getitmbyid(Request $request)
    {
        $item  = Items::select(['accessary', 'complain', 'make', 'remarks'])->where(['name' => $request->name])->first();

        return response()->json($item);
    }


}

