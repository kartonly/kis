<?php

namespace App\Http\Controllers\API\User;

use App\Http\Controllers\Controller;
use App\Models\Agreement;
use App\Models\City;
use App\Models\Clients;
use App\Models\Country;
use App\Models\Hotels;
use App\Models\HotelsStops;
use App\Models\Preagreement;
use App\Models\Rooms;
use App\Models\Stops;
use App\Models\Tourists;
use App\Models\Voucher;
use App\VoucherManager;
use Illuminate\Http\Request;

class VaucherController extends Controller
{
    public function index(Request $request){
        $vouchers = Voucher::all();

        return $vouchers;
    }

    public function item($voucher){
        $item = Voucher::where('id', $voucher)->first();
        $agr = Agreement::where('id', $item->agreement)->first();
        $preagr = Preagreement::where('id', $agr->preagreement)->first();
        $client = Clients::where('id', $preagr->clientId)->first();
        $stops = Stops::where('agreement', $agr->id)->get();
        $tourists = Tourists::where('agreement', $agr->id)->get();

        $numbers = [];
        foreach ($stops as $stop){
            $room = Rooms::where('stopId', $stop['id'])->first();
            if ($room!==null){
                array_push($numbers, $room);
            }
        }

        $hotels = [];
        foreach ($numbers as $number){
            $hotel = Hotels::where('id', $number['hotel'])->first();
            if ($hotel!==null) {
                array_push($hotels, $hotel);
            }
        }

        $cities = [];
        foreach ($hotels as $city){
            $city = City::where('id', $city['cityId'])->first();
            if ($city!==null){
                array_push($cities, $city);
            }
        }

        $countries = [];
        foreach ($cities as $country){
            $country = Country::where('id', $country['country'])->first();
            if ($country!==null){
                array_push($countries, $country);
            }
        }

        return [$item, $agr, $preagr, $tourists, $client, $numbers, $hotels, $cities, $countries];
    }

    public function create($agr, Request $request){
        $item = Agreement::where('id', $agr)->first();

        if ($item->payment == 1){
            $voucherManager = app(VoucherManager::class);
            $voucher = $voucherManager->create($request->all(), $agr);

            return $voucher;
        };

    }
}
