<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Clients;
use App\Models\Addresses;
use App\Traits\GoogleMaps;

class getGeoLocation implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    use GoogleMaps;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $clients = Clients::where('raw_address', '<>', null)->get();
        foreach($clients as $client) {
            $info = $this->getGeoLocationData($client);
            if($info != false){
                $address = new Addresses;
                $address['client_id'] = $client->id;
                $address['address'] = json_encode($info['address']);
                $address['geolocation'] = json_encode($info['geoLocation']);
                $address->save();
                $client['raw_address'] = null;
                $client->save();
                event(new \App\Events\GmapEvent());
            }
        }
    }
}
