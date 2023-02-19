<?php

namespace App\Http\Controllers\API\User;

use App\ClientManager;
use App\Http\Controllers\Controller;
use App\Http\Resources\ClientResource;
use App\Http\Resources\PassportResource;
use App\Models\Clients;
use App\Models\IntPassport;
use App\Models\Passport;
use Facade\FlareClient\Http\Client;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ClientController extends Controller
{

    public function index(Request $request){
        $clients=Clients::all();
        return ClientResource::collection($clients)->toArray($request);
    }

    public function item($client){
        $item = Clients::where('id', $client)->first();
        $passport = Passport::where('clientId', $item->id)->first();
        $intPassport = IntPassport::where('clientId', $item->id)->first();

        return [new ClientResource($item), new PassportResource($passport), $intPassport];
    }

    public function create(Request $request){
        $phone = $request->phone;
        $clientAdded =  app(ClientManager::class)->create($request->all(), $phone);

        return new ClientResource($clientAdded);
    }

    public function createPassport(Request $request, $client){
        $clientPassportAdded =  app(ClientManager::class)->createPassport($request->all(), $client);

        return $clientPassportAdded;
    }

    public function createIntPassport(Request $request, $client){

        $clientIntPassportAdded =  app(ClientManager::class)->createIntPassport($request->all(), $client);

        return new ClientResource($clientIntPassportAdded);
    }

    public function update(Request $request, Clients $client)
    {
        $phone = $request->phone;
        $clientManager = app(ClientManager::class, ['client' => $client]);
        $client = $clientManager->update($request->all(), $phone);

        return new ClientResource($client);
    }

    public function updatePassport(Request $request, Passport $passport)
    {
        $clientPassport = app(ClientManager::class, ['passport' => $passport]);
        $passport = $clientPassport->updatePassport($request->all());

        return $passport;
    }

    public function updateIntPassport(Request $request, $client)
    {
        $clientIntPassport = app(ClientManager::class);
        $intPassport = $clientIntPassport->updateIntPassport($request->all(), $client);

        return $intPassport;
    }

    public function delete(Clients $client)
    {
        app(ClientManager::class, ['client' => $client])->delete();
    }

    public function deletePassport(Passport $passport){
        app(ClientManager::class, ['passport' => $passport])->delPassport();
    }
}
