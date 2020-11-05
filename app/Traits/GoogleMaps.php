<?php

namespace App\Traits;

use Carbon\Carbon;
use App\Models\Clients;


trait GoogleMaps
{
    public function getGeoLocationData(Clients $client){
        $apiKey = config('app.gmaps_key');
        return $apiKey;
    }
}
