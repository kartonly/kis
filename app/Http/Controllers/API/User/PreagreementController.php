<?php


namespace App\Http\Controllers\API\User;


use App\ClientManager;
use App\Http\Controllers\Controller;
use App\Http\Resources\ClientResource;
use App\Http\Resources\UserResource;
use App\Models\City;
use App\Models\Clients;
use App\Models\Country;
use App\Models\Hotels;
use App\Models\Preagreement;
use App\Models\PreagreementCities;
use App\Models\User;
use App\PreagreementManager;
use http\Client;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class PreagreementController extends Controller
{
    public function index(Request $request)
    {
        $user = User::all()->find(Auth::user());
        $org=$user->organisation;

        $preagreements = Preagreement::where('organisationId', $org)->get();

        return $preagreements;
    }

    public function reminder(){
        $user = User::all()->find(Auth::user());
        $org=$user->organisation;
        $preagreements = Preagreement::where('organisationId', $org)->where('agreement', 0)->get();

        return $preagreements;
    }

    public function item($preagr){
        $item = Preagreement::where('id', $preagr)->first();
        $cities = PreagreementCities::where('preagreementId', $preagr)->get()->values()->all();

//        $city = City::where('id', function () use($cities){
//            foreach ($cities as $city){
//                return $city->cityId;
//            }
//        })->get();
        $cityArray = [];
        foreach ($cities as $city){
            $cityAr = City::where('id', $city->cityId)->first();
            array_push($cityArray, $cityAr);
        }

        $client = Clients::where('id', $item->clientId)->first();
        $employee = User::where('id', $item->employee)->first();

        return [$item, $cityArray, new ClientResource($client), $employee];
    }

    public function create(Request $request){
        $userAll = User::all()->find(Auth::user());
        $user = $userAll->id;
        $org=$userAll->organisation;
        $citiesReq = $request->cities;

        $preagreementManager = app(PreagreementManager::class);
        $preagreement = $preagreementManager->create($request->all(), $user, $org, $citiesReq);
    }

    public function update(Request $request, Preagreement $preagreement)
    {
        $preagreementManager = app(PreagreementManager::class, ['preagreement' => $preagreement]);
        $preagreement = $preagreementManager->update($request->all());

        return $preagreement;
    }

    public function updateCities(Request $request, $preagr){
        $citiesManager = app(PreagreementManager::class);
        $cities = $citiesManager->updateCities($request->cities, $preagr);

        return $cities;
    }

    public function getClients(){
        $clients = Clients::all()->with('passport')->with('intPassport')->get();

        return $clients;
    }

    public function getCountries(){
        $country = Country::all();

        return $country;
    }

    public function getCities(){
        $cities = City::all();

        return $cities;
    }

    public function getHotels(){
        $hotels = Hotels::all();

        return $hotels;
    }

    public function delete(Preagreement $preagreement){
        app(PreagreementManager::class, ['preagreement' => $preagreement])->delete();
        return new Response([]);
    }
}
