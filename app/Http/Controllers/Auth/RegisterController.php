<?php


namespace App\Http\Controllers\Auth;


use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\Organisation;
use App\UserManager;
use Illuminate\Http\Response;
use Illuminate\Support\Str;

class RegisterController extends Controller
{
    public function __invoke(RegisterRequest $request){
        $remember=false;
        $email = $request->input('email');
        $password = $request->input('password');

        $userManager = app(UserManager::class);
        $user = $userManager->create($request->all());

        $token = $userManager->auth($email, $password, $remember);

        return (new Response([$user->id], 200))->header('Access-Control-Allow-Origin', '*');
    }

    public function getOrganisation(){
        $organisations = Organisation::all();

        return $organisations;
    }
}
