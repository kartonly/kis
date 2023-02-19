<?php


namespace App;


use App\Models\Payment;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class PaymentManager
{
    private ?Payment $payment;

    public function __construct(?Payment $payment = null)
    {
        $this->payment = $payment;
    }

    public function create(array $data, $user, $org, $agr){
        DB::transaction(function () use ($data, $org, $user, $agr) {
            $this->payment=app(Payment::class);
            $this->payment->organisation=$org;
            $this->payment->date=Carbon::now();
            $this->payment->agreement = $agr;
            $this->payment->employee = $user->id;
            $this->payment->summ = $data['summ'];
            $this->payment->save();
        });
    }
}
