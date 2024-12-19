<?php

namespace App\Http\Controllers;

use App\Models\Modellist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;

class ModellistController extends Controller
{
    public function getModel(Request $request)
    {
        $make = $request->input('make');
        $type = $request->input('type');
        $model = $request->input('model');


        // Validate the incoming request data
        $request->validate([
            'make' => 'required|string|max:70',
            'type' => 'required|string|max:70',
        ]);



        $models = Modellist::where('make', $make)
        ->where('type', $type)
        ->where('model', 'like', '%' . $model . '%')

        ->select('model')
        ->get();

        // Return the matching models as a JSON response
        return response()->json($models);
    }
}
