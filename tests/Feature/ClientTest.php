<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\Clients;
use Tests\TestCase;

class ClientTest extends TestCase
{
    use RefreshDatabase;

    public function testRouteToGetClientsExists()
    {
        $response = $this->get('/api/clients');
        $response->assertStatus(200);
    }

    public function testRouteToDeleteClientsExists()
    {
        $response = $this->delete('/api/clients/1');
        $response->assertStatus(401);
    }

    public function testCanGetClients()
    {
        $client = new Clients;
        $client['name'] = "Usuário Teste";
        $client['email'] = "teste@teste.com";
        $client['doc'] = "111.111.111.22";
        $client['birthday'] = "1990-01-01";
        $client->save();

        $response = $this->get('/api/clients');
        $response->assertStatus(200);
        $response->assertJson([['email' => "teste@teste.com"]], $strict = false);
    }

    public function testCanDeleteClient()
    {
        $client = new Clients;
        $client['name'] = "Usuário Teste";
        $client['email'] = "teste2@teste.com";
        $client['doc'] = "111.111.111.22";
        $client['birthday'] = "1990-01-01";
        $client->save();

        $response = $this->delete('/api/clients/'.$client->id);
        $response->assertStatus(200);

        $this->assertDatabaseMissing('clients', [
            'email' => 'teste2@teste.com',
        ]);
    }

    public function testCantDeleteAClientThatDoesntExist()
    {
        $response = $this->delete('/api/clients/55');
        $response->assertStatus(401);
    }
}
