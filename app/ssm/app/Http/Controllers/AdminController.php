<?php

namespace App\Http\Controllers;

use App\Models\Appinfo;
use App\Models\Client;
use App\Models\ClientPayment;
use App\Models\AuditLogModel;
use App\Models\Jobs;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AdminController extends Controller
{
    function index() {






        $centeredText = 'Dashboard';



        return view('admin.dashboard', [

            'centeredText' => $centeredText,

        ]);

        // }
        }







}
