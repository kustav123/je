<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class ReloadCacheController extends Controller
{

    function index() {
        Cache::flush();
        }
}
