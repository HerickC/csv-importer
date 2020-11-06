<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Clients;
use App\Models\Addresses;
use App\Traits\GoogleMaps;
use App\Jobs\getGeoLocation;
use Carbon\Carbon;

class ClientController extends Controller
{
    use GoogleMaps;

    public function getClients(){
        $formatedClients = [];

        $clients = Clients::with("addresses")->get();
        foreach($clients as $client) {
            $firstAddress = ['city' => null];
            $firstGeoLocation = ['lat'=> null, 'lng'=> null];
            foreach($client->addresses as $address){
                $firstAddress = json_decode($address->address, true);
                $firstGeoLocation = isset($address->geolocation) ? json_decode($address->geolocation, true) : ['lat'=> null, 'lng'=> null];
                break;
            }

            array_push($formatedClients, [
                'id' => $client->id,
                'name' => $client->name,
                'email' => $client->email,
                'cpf' => $client->doc,
                'birthday' => Carbon::createFromFormat('Y-m-d', $client->birthday)->format('d/m/Y'),
                'address' => $firstAddress,
                'geoLocation' => $firstGeoLocation,
            ]);
        }

        return response()->json($formatedClients);
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


    public function testGmap($id)
    {

        return 'ok';
    }
}
