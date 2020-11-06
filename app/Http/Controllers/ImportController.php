<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Imports\ClientsImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Jobs\getGeoLocation;

class ImportController extends Controller
{
    public function importClients(Request $request)
    {
        if($request->file('clients') == null) return response()->json($response, 401);

        Excel::import(new ClientsImport, $request->file('clients'));
        getGeoLocation::dispatch();

        return response()->json([], 200);
    }
}
