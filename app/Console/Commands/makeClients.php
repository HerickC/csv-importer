<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Imports\ClientsImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Jobs\getGeoLocation;

class makeClients extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:clients {path}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cria novos clientes através de um arquivo CSV';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $path = $this->argument('path');
        $file = $path;
        if($file != false){
            Excel::import(new ClientsImport, $file);
            getGeoLocation::dispatch();
            $this->info("Importação concluída com sucesso!");
        } else {
            $this->error('Arquivo inválido');
        }

    }
}
