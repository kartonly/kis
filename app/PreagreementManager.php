<?php


namespace App;


use App\Models\Preagreement;
use App\Models\PreagreementCities;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class PreagreementManager
{
    private ?Preagreement $preagreement;

    public function __construct(?Preagreement $preagreement = null)
    {
        $this->preagreement = $preagreement;
    }

    public function create(array $data, $user, $org, $citiesReq){
        DB::transaction(function () use ($data, $org, $user) {
            $this->preagreement=app(Preagreement::class);
            $this->preagreement->organisationId=$org;
            $this->preagreement->clientId=$data['clientId'];
            $this->preagreement->TouristsCount = $data['TouristsCount'];
            $this->preagreement->employee = $user;
            $this->preagreement->start=$data['start'];
            $this->preagreement->end=$data['end'];
            $this->preagreement->date=Carbon::now();
            $this->preagreement->agreement=0;
            $this->preagreement->save();
        });

        if ($citiesReq != null){
            foreach ($citiesReq as $city){
                $this->city = new PreagreementCities();
                $this->city->preagreementId = $this->preagreement->id;
                $this->city->cityId = $city['id'];
                $this->city->save();
            }
        }

        return $this->preagreement;
    }

    public function update(array $params): Preagreement
    {
        $this->preagreement->fill($params);
        $this->preagreement->save();

        return $this->preagreement;
    }

    public function updateCities(array $params, $preagr): PreagreementCities
    {
        PreagreementCities::where('preagreementId', $preagr)->delete();
        foreach ($params as $city){
            $this->city = new PreagreementCities();
            $this->city->preagreementId = $preagr;
            $this->city->cityId = $city["id"];
            $this->city->save();
        }

//        $this->cities = PreagreementCities::where('preagreementId', $preagr);
//        $this->cities->fill($params);
//        $this->cities->save();

        return PreagreementCities::where('preagreementId', $preagr)->first();
    }

    public function delete(){
        PreagreementCities::where('preagreementId', $this->preagreement->id)->delete();
        $this->preagreement->delete();
    }
}
