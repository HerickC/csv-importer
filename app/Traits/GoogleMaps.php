<?php

namespace App\Traits;

use Carbon\Carbon;
use App\Models\Clients;


trait GoogleMaps
{
    public function getGeoLocationData(Clients $client){
        $apiKey = config('app.gmaps_key');
        if($client->raw_address == null) return false;
        $address = str_replace(' ', '+', $client->raw_address);
        $gmapsInfo = file_get_contents("https://maps.googleapis.com/maps/api/geocode/json?address=".$address."&key=".$apiKey);
        $gmapsInfo = json_decode($gmapsInfo, true);
        $address = [];
        $geoLocation = null;
        if($gmapsInfo['status'] == 'OK'){
            if(count($gmapsInfo['results']) >= 1){
                $GMapAddressComponents = $gmapsInfo['results'][0]['address_components'];
                foreach($GMapAddressComponents as $item){
                    $types = $item['types'];
                    if(count($types) == 1) {
                        $type = $types[0];
                    }else {
                        foreach($types as $subType){
                            $selectedSubTypes = ['sublocality_level_1', 'administrative_area_level_1', 'administrative_area_level_2', 'country'];
                            if(in_array($subType, $selectedSubTypes)){
                                $type = $subType;
                                break;
                            }
                        }
                    }
                    if($type == 'subpremise') $address['complementary'] = $item['short_name'];
                    if($type == 'street_number') $address['street_number'] = $item['long_name'];
                    if($type == 'route') $address['street'] = $item['short_name'];
                    if($type == 'sublocality_level_1') $address['neighborhood'] = $item['long_name'];
                    if($type == 'administrative_area_level_2') $address['city'] = $item['long_name'];
                    if($type == 'administrative_area_level_1') $address['state'] = $item['long_name'];
                    if($type == 'country') $address['country'] = $item['long_name'];
                    if($type == 'postal_code') $address['zipcode'] = $item['long_name'];
                }
                $geometryGmaps = $gmapsInfo['results'][0]['geometry'];
                $geoLocation = [
                    'lat' => $geometryGmaps['location']['lat'],
                    'lng' => $geometryGmaps['location']['lng'],
                ];
            }
        }
        $GmapsFormated = [
            'address' => $address,
            'geoLocation' => $geoLocation
        ];

        return $GmapsFormated;
    }
}
