<?php


namespace App;


use App\Models\Agreement;
use App\Models\Hotels;
use App\Models\HotelsStops;
use App\Models\Preagreement;
use App\Models\PreagreementCities;
use App\Models\Rooms;
use App\Models\Stops;
use App\Models\Tourists;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class AgreementManager
{
    private ?Agreement $agreement;

    public function __construct(?Agreement $agreement = null)
    {
        $this->agreement = $agreement;
    }

    public function create(array $data, $user, $org, $preagr, $tourists, $rooms, $hotels, $preagreement){
        $pr = Preagreement::where('id', $preagr)->first();
        DB::transaction(function () use ($data, $org, $user, $pr, $preagr) {
            $this->agreement=new Agreement();
            $this->agreement->organisation=$org;
            $this->agreement->date=Carbon::now();
            $this->agreement->preagreement = $preagr;
            $this->agreement->employee = $user->id;
            $this->agreement->start=$pr->start;
            $this->agreement->end=$pr->end;
            $this->agreement->payment=0;
            $this->agreement->save();
        });

        if ($tourists != null){
            foreach ($tourists as $tourist){
                $this->tourist = new Tourists();
                $this->tourist->agreement = $this->agreement->id;
                $this->tourist->first_name = $tourist['first_name'];
                $this->tourist->second_name = $tourist['second_name'];
                $this->tourist->last_name = $tourist['last_name'];
                $this->tourist->passportId = $tourist['passportId'];
                $this->tourist->passportSeries = $tourist['passportSeries'];
                $this->tourist->save();
            }
        };

        $stops = PreagreementCities::where('preagreementId', $preagr)->get()->values()->all();
        $redact = Preagreement::where('id', $preagr)->first();
        $redact->agreement = 1;
        $redact->save();

        if ($stops != null){
            foreach ($stops as $stop){
                $this->stop = new Stops();
                $this->stop->agreement = $this->agreement->id;
                $this->stop->city = $stop['preagreementId'];
                $this->stop->save();
            }
        };

        if ($hotels != null){
            foreach ($hotels as $hotel){
                $this->hotel = new HotelsStops();
                $hotelId = Hotels::where('id', $hotel['id'])->first()->id;
                $stop = HotelsStops::where('hotelId', $hotelId)->first()->stopId;
                $this->hotel->stiopId = $stop;
                $this->hotel->hotelId =$hotel['id'];
                $this->hotel->save();
            }
        };


        if ($rooms != null){
            foreach ($rooms as $stop){
                $this->room = new Rooms();
                $this->room->stopId = $this->agreement->id;
                $this->room->bedCount = $stop['bedCount'];
                $this->room->food = $stop['food'];
                $this->room->roomType = $stop['roomType'];
                $this->room->arrival = $stop['arrival'];
                $this->room->departure = $stop['departure'];
                $this->room->hotel = $stop['hotel'];
                $this->tourist->save();
            }
        };
    }
    public function addTourist(array $params, $agr){
        DB::transaction(function () use ($params, $agr) {
            $this->tourist = new Tourists();
            $this->tourist->agreement = $agr;
            $this->tourist->first_name = $params['first_name'];
            $this->tourist->second_name = $params['second_name'];
            $this->tourist->last_name = $params['last_name'];
            $this->tourist->passportId = $params['passportId'];
            $this->tourist->passportSeries = $params['passportSeries'];
            $this->tourist->save();
        });
    }

    public function delete(){
        $this->agreement->delete();
    }
}
