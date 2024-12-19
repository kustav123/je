<?php

namespace App\Http\Controllers;

use App\Models\DeliveryChallanData;
use Illuminate\Http\Request;

class SrvGstInvController extends Controller
{
    public function index(Request $request)
    {
        $appinfo = new AppinfoController();
        $listcomp = $appinfo->getlist();
        $centeredText = 'GST Invoice for Service and Product';

        return view('invoice.srvGst.gen', ['listcomp' => $listcomp, 'centeredText' => $centeredText,]);
    }
}
