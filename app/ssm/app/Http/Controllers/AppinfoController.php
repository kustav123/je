<?php

namespace App\Http\Controllers;

use App\Models\Appinfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AppinfoController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Appinfo::select(['id', 'name', 'logo', 'address', 'gstno', 'type', 'apptype'])  -> get() ->toArray();
            return $data;
    }
}
public function getlist()
    {
            $data = Appinfo::select(['id', 'name' ]) ->where('status',true)     ->orderBy('id', 'desc')
            -> get() ->toArray();
            return $data;
}

    public function pri(Request $request)
    {
        if ($request->ajax()) {
            $data = Appinfo::select(['id', 'name', 'logo', 'address', 'gstno', 'type', 'apptype']) ->where('type','p') -> get();
            return $data;

    }
}
public function byid($id)
{
    $data = Appinfo::select([
        'name as cname',
        'logo',
        'address',
        'gstno',
        'email',
        'cont1',
        'cont2',
        'bank_account_holder_name',
        'bank_name',
        'bank_branch',
        'bank_ac_no',
        'bank_ifsc',
        'bank_qr'
    ])->where('id', $id)->first();
     return $data;
}
}


