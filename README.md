# Platform to import clients and find their geolocation

The main objective of this repository is to create a system where it is possible to register customers using a CSV file, and have their data updated with the google API, validating their address and searching for their Latitude and Longitude.

## Installation
Para executar o sistema em modo de desenvolvimento:

1. **Copy the .env.example file to .env**
2. Edit the **.env** file to reflect your System Database configuration, Pusher Config and Gmaps Key
3. Install composer dependencies: **composer install**
4. Run the platform:
   1. Docker Mode
      1. Run **docker-compose build**
      2. Run **docker-compose up**
      3. Open your browser in **http://localhost:8080** 
   2. Laravel Dev Mode 
      1. Run **php artisan Migrate**
      2. Run **php artisan serve**
      3. Run **php artisan queue:work**
      4. Open your browser in **http://localhost:8000** 

## Features
   - [X] Import CSV
   - [x] GMaps Integration (GeoCoding)
   - [x] Bootstrap Layout
   - [x] Docker + Docker Compose
   - [X] Tables with Relationship
   - [X] GeoCoding Asynchronous processing(Queues)
   - [X] Update Events with WebSocket
   - [X] Upload with Axios
   - [X] Export of clients compatible with import
   - [X] Import Clients from Command Line: **php artisan create:clients './FilePath'**
   - [X] Remove individual clients
   - [X] 100% tests coverage 


## CSV structure:

| nome     |      email      |     datanasc |       cpf      |                                            endereco                       | cep       |
|----------|-------------------|:----------:|:--------------:| ------------------------------------------------------------------------- | :--------:|
|Cliente 1 |  teste1@teste.com | 05/10/1993 | 123.456.789-01 | "Av Paulista, 123 - Pinheiros – São Paulo"                                | 01311-000 |
|Cliente 2 |  teste2@teste.com | 05/10/1992 | 123.456.789-01 | "Avenida Dr. Gastão Vidigal, 1132 Sala 123 - Vila Leopoldina – São Paulo" | 05314-010 |



Example (included in root folder):
```
nome,email,datanasc,cpf,endereco,cep
Cliente 1,teste1@teste.com,05/10/1993,123.456.789-01,"Av Paulista, 123 - Pinheiros – São Paulo",01311-000
Cliente 2,teste2@teste.com,05/10/1992,123.456.789-09,"Avenida Dr. Gastão Vidigal, 1132 Sala 123 - Vila Leopoldina – São Paulo",05314-010
Cliente 3,teste3@teste.com,05/10/1991,123.456.789-17,"Rua Caçapava, 123 – Novo Riacho – Contagem",32285-030
Cliente 4,teste4@teste.com,05/10/1990,123.456.789-25,"Rua Rio Sacramento, 421 Bloco A, Apt 402 – Contagem",32280-470
Cliente 5,teste5@teste.com,05/10/1989,123.456.789-33,"R. Tubira, 88 - Novo Eldorado, Contagem",32340-460
Cliente 6,teste6@teste.com,05/10/1988,123.456.789-41,"Av. João César de Oliveira, 2859 - Eldorado, Contagem",32310-000
Cliente 7,teste7@teste.com,05/10/1987,123.456.789-49,"Av. Pres. Antônio Carlos, 3860 - Pampulha, Belo Horizonte",31270-000
Cliente 8,teste8@teste.com,05/10/1986,123.456.789-57,"Av. do Contorno, 9530 - Barro Preto, Belo Horizonte",30110-934
Cliente 9,teste9@teste.com,05/10/1985,123.456.789-65,"Av. Presidente Carlos Luz, 3001 - Pampulha, Belo Horizonte",31250-010
```


