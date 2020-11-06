<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ExportTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testRouteToExportClientsExists()
    {
        $this->withoutExceptionHandling();
        $response = $this->get('/export');

        $response->assertStatus(200);
    }
}
