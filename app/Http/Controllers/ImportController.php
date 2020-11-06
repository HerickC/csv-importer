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
        if(!$request->hasFile('clients')) return response()->json([], 401);

        Excel::import(new ClientsImport, $request->file('clients'));
        getGeoLocation::dispatch();

        return response()->json([], 200);
    }
}
