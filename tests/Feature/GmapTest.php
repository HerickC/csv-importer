<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\Clients;
use App\Traits\GoogleMaps;

use Tests\TestCase;

class GmapTest extends TestCase
{
    use GoogleMaps;
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testGmapReturnsAddressInfo()
    {
        $client = new Clients;
        $client['name'] = "Usuário Teste";
        $client['email'] = "teste2@teste.com";
        $client['doc'] = "111.111.111.22";
        $client['birthday'] = "1990-01-01";
        $client['raw_address'] = 'Av Paulista, 123 - Pinheiros – São Paulo';
        $client->save();

        $info = $this->getGeoLocationData($client);

        $this->assertArrayHasKey('state', $info['address']);
        $this->assertTrue($info['address']['state'] == 'São Paulo');
    }
}
