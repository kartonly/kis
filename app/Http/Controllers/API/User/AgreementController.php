<?php

namespace App\Http\Controllers\API\User;

use App\AgreementManager;
use App\Http\Controllers\Controller;
use App\Http\Resources\ClientResource;
use App\Models\Agreement;
use App\Models\City;
use App\Models\Clients;
use App\Models\Hotels;
use App\Models\HotelsStops;
use App\Models\Preagreement;
use App\Models\PreagreementCities;
use App\Models\Rooms;
use App\Models\Stops;
use App\Models\Tourists;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class AgreementController extends Controller
{
    public function index(Request $request)
    {
        $user = User::all()->find(Auth::user());
        $org=$user->organisation;
        $agreements = Agreement::where('organisation', $org)->get();
        return $agreements;
    }

    public function preagr($agr){
        $agr = Agreement::where('id', $agr)->first();
        $item = Preagreement::where('id', $agr->preagreement)->first();
        $cities = PreagreementCities::where('preagreementId', $item->id)->get()->values()->all();

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

    public function item($agr){
        $item = Agreement::where('id', $agr)->first();
        $preagr = Preagreement::where('id', $item->preagreement)->first();
        $tourists = Tourists::where('agreement', $item->id)->get();
        $stops = Stops::where('agreement', $item->id)->get();

        $rooms = [];
        foreach ($stops as $stop){
            $room = HotelsStops::where('stopId', $stop['id'])->first();
            if ($room!==null){
                array_push($rooms, $room);
            }
        }

        $hotels = [];
        foreach ($rooms as $hotel){
            $room = Hotels::where('id', $hotel['hotelId'])->first();
            if ($room!==null){
                array_push($hotels, $room);
            }
        }

        $numbers = [];
        foreach ($stops as $stop){
            $room = Rooms::where('stopId', $stop['id'])->first();
            if ($room!==null){
                array_push($numbers, $room);
            }
        }

        return [$item, $preagr, $numbers, $tourists, $hotels];
    }

    public function create(Request $request, $preagr){
        $user = User::all()->find(Auth::user());
        $org=$user->organisation;
        $tourists = $request->tourists;
        $rooms = $request->room;
        $hotels = $request->hotel;
        $prFull = Preagreement::where('id', $preagr)->take(1);

        $preagreementManager = app(AgreementManager::class);
        $preagreement = $preagreementManager->create($request->all(), $user, $org, $preagr, $tourists, $rooms, $hotels, $prFull);

        return $preagreement;
    }

    public function addTourist(Request $request, $agr){
        $preagreementManager = app(AgreementManager::class);
        $preagreement = $preagreementManager->addTourist($request->all(), $agr);

        return $preagreement;
    }

    public function hotels($city){
        $hotels = Hotels::all();

        return $hotels;
    }

    public function delete(Agreement $agreement){
        app(AgreementManager::class, ['eagreement' => $agreement])->delete();
        return new Response([]);
    }
}
