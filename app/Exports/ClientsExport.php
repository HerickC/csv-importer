<?php

namespace App\Exports;

use App\Models\Clients;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithCustomCsvSettings;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Carbon\Carbon;

class ClientsExport implements FromArray, WithCustomCsvSettings, WithHeadings
{

    public function array(): array
    {
        $formatedClients = [];
        $clients = Clients::with("addresses")->get();
        $firstAddress = ['city' => null];
        $firstGeoLocation = ['lat'=> null, 'lng'=> null];
        foreach($clients as $client) {
            $firstAddress = ['city' => null];
            $firstGeoLocation = ['lat'=> null, 'lng'=> null];
            foreach($client->addresses as $address){
                $firstAddress = json_decode($address->address, true);
                $firstGeoLocation = isset($address->geolocation) ? json_decode($address->geolocation, true) : ['lat'=> null, 'lng'=> null];
                break;
            }
            $complement = isset($firstAddress['complementary']) ? ', '.$firstAddress['complementary'] : '';
            $address = $firstAddress['street'].', '.$firstAddress['street_number'].$complement.' - '.$firstAddress['neighborhood'];
            $address = $address.' - '.$firstAddress['city'].' - '.$firstAddress['state'];
            array_push($formatedClients, [
                'nome' => $client->name,
                'email' => $client->email,
                'datanasc' => Carbon::createFromFormat('Y-m-d', $client->birthday)->format('d/m/Y'),
                'cpf' => $client->doc,
                'endereco' => $address,
                'cep' => $firstAddress['zipcode'],
                'logradouro' => $firstAddress['street'],
                'numero' => $firstAddress['street_number'],
                'complemento' => $complement,
                'bairro' => $firstAddress['neighborhood'],
                'cidade' => $firstAddress['city'],
                'estado' => $firstAddress['state'],
                'pais' => $firstAddress['country'],
                'lat' => $firstGeoLocation['lat'],
                'lng' => $firstGeoLocation['lng'],
            ]);
        }
        return $formatedClients;
    }

    public function getCsvSettings(): array
    {
        return [
            'delimiter' => ','
        ];
    }

    public function headings(): array
    {
        return [
            'nome',
            'email',
            'datanasc',
            'cpf',
            'endereco',
            'cep',
            'logradouro',
            'numero',
            'complemento',
            'bairro',
            'cidade',
            'estado',
            'pais',
            'lat',
            'lng'
        ];
    }
}
