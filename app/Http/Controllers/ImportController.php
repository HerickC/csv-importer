<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Imports\ClientsImport;
use Maatwebsite\Excel\Facades\Excel;

class ImportController extends Controller
{
    public function importClients(Request $request)
    {
        $response = [
            'hasError' => true,
            'insertedItem' => false,
        ];
        if($request->file('clients') == null) return response()->json($response, 401);

        Excel::import(new ClientsImport, $request->file('clients'));


        return response()->json($response, 200);
    }
}
