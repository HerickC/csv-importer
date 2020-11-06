<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class UploadTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testRouteToUploadCsv()
    {
        $response = $this->post('/api/import');
        $response->assertStatus(401);
    }

    public function testImportCreateNewClients()
    {

        Storage::fake('uploads');

        $header = 'nome,email,datanasc,cpf,endereco,cep' . PHP_EOL;
        $row1 = 'Cliente 1,teste1@teste.com,05/10/1993,123.456.789-01,"Av Paulista, 123 - Pinheiros – São Paulo",01311-000' . PHP_EOL;
        $row2 = 'Cliente 2,teste2@teste.com,05/10/1992,123.456.789-09,"Avenida Dr. Gastão Vidigal, 1132 Sala 123 - Vila Leopoldina – São Paulo",05314-010';

        $content = implode("", [$header, $row1, $row2]);

        $inputs = [
            'clients' =>
                UploadedFile::
                    fake()->
                    createWithContent(
                        'test.csv',
                        $content
                    )
        ];
        $response = $this->post('/api/import', $inputs);
        $response->assertStatus(200);

        $this->assertDatabaseHas('clients', [
            'email' => 'teste1@teste.com',
        ]);
    }
}
