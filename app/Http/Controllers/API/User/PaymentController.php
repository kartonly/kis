<?php

namespace App\Http\Controllers\API\User;

use App\Http\Controllers\Controller;
use App\Models\Agreement;
use App\Models\Payment;
use App\Models\User;
use App\Models\Values;
use App\PaymentManager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    public function index(Request $request)
    {
        $user = User::all()->find(Auth::user());
        $org=$user->organisation;
        $payments = Payment::where('organisation', $org)->get();
        return $payments;
    }
    public function item($agr){
        $item = Payment::where('id', $agr)->first();

        return $item;
    }

    public function create(Request $request, $agr){
        $user = User::all()->find(Auth::user());
        $org=$user->organisation;

        $paymentManager = app(PaymentManager::class);
        $payment = $paymentManager->create($request->all(), $user, $org, $agr);

        $agreement = Agreement::where('id', $agr)->first();
        $agreement->payment=1;
        $agreement->save();

        return $payment;
    }

    public function values(){
        $values = Values::all();

        return $values;
    }
}
