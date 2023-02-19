<?php


namespace App\Http\Controllers\Auth;


use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\UserManager;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function __invoke(LoginRequest $request)
    {
        $email = $request->input('email');
        $password = $request->input('password');
        $remember = $request->input('remember');

        $userManager = app(UserManager::class);
        $token = $userManager->auth($email, $password, $remember);

//        if ((Carbon::now()>Carbon::parse(6))&(Carbon::now()<Carbon::parse(18))){
//            $login = Login::where('userId', Auth::user()->id)->first();
//            $login->day=$login->day+1;
//            $login->save();
//        } else {
//            $login = Login::where('userId', Auth::user()->id)->first();
//            $login->night=$login->night+1;
//            $login->save();
//        }

        return (new Response(['Authorization','Bearer '.$token], 200))->header('Access-Control-Allow-Origin', '*');
    }
}
