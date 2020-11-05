<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Clients;
use App\Models\Addresses;

class ClientController extends Controller
{
    //

    public function getClients(){
        $clients = Clients::all();
        return response()->json($clients);
    }

    public function deleteClient($id){
        $status = 401;

        $addresses = Addresses::where('client_id', $id)->get();
        foreach ($addresses as $address){
            $address->delete();
        }
        $client = Clients::find($id);
        if(isset($client->id)){
            $status = 200;
            $client->delete();
        }

        return response('', $status);
    }
}
