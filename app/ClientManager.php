<?php


namespace App;


use App\Models\Clients;
use App\Models\IntPassport;
use App\Models\Passport;
use Illuminate\Support\Facades\DB;

class ClientManager
{
    private ?Clients $client;
    private ?Passport $passport;
    private ?IntPassport $intPassport;

    public function __construct(?Clients $client = null, ?Passport $passport = null, ?IntPassport $intPassport = null)
    {
        $this->client = $client;
        $this->passport = $passport;
        $this->intPassport = $intPassport;
    }

    public function create(array $params, $phone): Clients
    {
        DB::transaction(function () use ($params, $phone) {
            $this->client=app(Clients::class);
            $this->client->fill($params);
            $this->client->phone = $phone;
            $this->client->save();

//            $this->passport=app(Passport::class);
//            $this->passport->clientId=$this->client->id;
//            $this->passport->fill($passport);
//            $this->passport->save();
//
//            if (isset($intPasssport)){
//                $this->intPassport=app(IntPassport::class);
//                $this->intPassport->clientId=$this->client->id;
//                $this->passport->fill($intPassport);
//                $this->passport->save();
//            }
        });
        return $this->client;
    }

    public function createPassport(array $params, $client): Passport
    {
        DB::transaction(function () use ($params, $client) {
            $this->passport=app(Passport::class);
            $this->passport->clientId = $client;
            $this->passport->fill($params);
            $this->passport->save();
        });
        return $this->passport;
    }

    public function createIntPassport(array $params, $client): IntPassport
    {
        DB::transaction(function () use ($params, $client) {
            $this->intPassport=app(IntPassport::class);
            $this->intPassport->clientId = $client;
            $this->intPassport->fill($params);
            $this->intPassport->save();
        });
        return $this->intPassport;
    }

    public function update(array $params, $phone): Clients
    {
        $this->client->fill($params);
        $this->client->phone = $phone;
        $this->client->save();

        return $this->client;
    }

    public function updatePassport(array $params): Passport
    {
        $this->passport->fill($params);
        $this->passport->save();

        return $this->passport;
    }
    public function updateIntPassport(array $params, $client): IntPassport
    {
        $this->intPassport = IntPassport::where('clientId', $client);
        $this->intPassport->fill($params);
        $this->intPassport->save();

        return $this->intPassport;
    }

    public function delete(){
        $this->client->delete();
    }

    public function delPassport(){
        $this->passport->delete();
    }
}
