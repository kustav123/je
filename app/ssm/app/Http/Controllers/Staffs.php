<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables as DataTables;

class Staffs extends Controller
{

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = User::select(['id', 'username','name', 'email', 'role']);

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    return view('admin.staff.action', compact('row'));
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('admin.staff.index');
    }

    public function store(Request $request)
    {
        $msg = "";
        $purpose = $request->purpose;
        if ($purpose == 'insert') {
            $request->validate([
                'name' => 'required',
                'username' => 'required|string|unique:appuser',
            ]);

            $sequence = DB::table('secuence')
            ->select('sno', 'head')
            ->where('type', 'user')
            ->lockForUpdate()
            ->first();

            $head =  $sequence->head ;
            $newclid = $sequence->sno + 1;
            $newclid = str_pad($newclid, 5, '0', STR_PAD_LEFT);
            $newclid =  $head . '-' . $newclid ;

            User::create([
                'id' => $newclid,
                'name' => $request->name,
                'email' => $request->email,
                'username' => $request->username,
                'role' => $request->role,
                'password' => bcrypt($request->password),
                'status' => 1
            ]);
            DB::table('secuence')
            ->where('type', 'user')
            ->increment('sno');
        cache()->forget('userlist');
            $msg = "Successfully staff created";
        } else if ($purpose == 'update') {
            $request->validate([
                'username' => 'required',
            ]);
            if ($request->changePassword == 'on') {
                User::where('id', $request->id)->update([
                    'name' => $request->name,
                    'password' => bcrypt($request->password),
                    'email' => $request->email,
                    'username' => $request->username,
                    'role' => $request->role

                ]);
                cache()->forget('userlist');

            } else {
                User::where('id', $request->id)->update([
                    'name' => $request->name,
                    'email' => $request->email,
                    'username' => $request->username,
                    'role' => $request->role
                ]);
            }
            $msg = "Successfully updated staff";
        }

        return response()->json([
            "status" => true,
            "message" => $msg,
        ]);
    }

    public function edit(Request $request)
    {
        $user  = User::select(['id', 'username', 'name', 'email'])->where(['id' => $request->id])->first();

        return response()->json($user);


    }

    public function destroy(Request $request)
    {
        $user = User::where('id', $request->id)->delete();
        cache()->forget('userlist');

        return Response()->json($user);
    }

    public function liststuff(Request $request)
    {
        $user =  Cache::rememberForever('userlist', function () {
            return User::select([
                'id', 'name'
                ])
                ->where('status',1)
                ->get();
            });
            return response()->json($user);

    }
}
