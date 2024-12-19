<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class InvNonGstController extends Controller
{
    public function index(Request $request)
    {
        $appinfo = new AppinfoController();
        $listcomp = $appinfo->getlist();
        $centeredText = 'Kancha Invoice for Service and Product';

        return view('invoice.nongst.gen', ['listcomp' => $listcomp, 'centeredText' => $centeredText,]);
    }

}
