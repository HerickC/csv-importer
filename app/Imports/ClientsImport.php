<?php

namespace App\Imports;

use App\Models\Clients;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Carbon\Carbon;

class ClientsImport implements ToModel, WithHeadingRow, WithChunkReading
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Clients([
            'name'          => $row['nome'],
            'email'         => $row['email'],
            'doc'           => $row['cpf'],
            'birthday'      => Carbon::createFromFormat('d/m/Y', $row['datanasc'])->format('Y-m-d'),
            'raw_address'   => $row['endereco'].' - '.$row['cep'],
        ]);
    }

    public function chunkSize(): int
    {
        return 1000;
    }
}
