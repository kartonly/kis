<?php


namespace App\Http\Controllers\API\User;


use App\Http\Controllers\Controller;
use App\Http\Requests\PhotoRequest;
use App\Http\Resources\UserResource;
use App\Models\Organisation;
use App\Models\Photo;
use App\UserManager;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UsersController extends Controller
{

    public function index(Request $request)
    {
        $user = User::all()
            ->find(Auth::user());
        $user->photo = $user->getFirstMediaUrl('avatar', 'thumb');
        $org=$user->organisation;
        $organisation=Organisation::where('id', $org)->first();

        return [new UserResource($user), $organisation];
    }

    public function update(Request $request, User $user)
    {

        $userManager = app(UserManager::class, ['user' => Auth::user()]);
        $user = $userManager->update($request->all());

        return new UserResource($user);
    }

    public function setAvatar(PhotoRequest $request, $user)
    {
        $file = app(UserManager::class, ['user' => User::where('id' == $user)->first()])->updateAvatar($request->file('photo'));

        return new JsonResponse($file->base64);
    }

    public function setMedia(Request $request, $user)
    {
        $file = app(UserManager::class, ['user' => User::where('id' == $user)->first()])->updateMedia($request->file('avatar'));

        return new JsonResponse($file->base64);
    }

    public function setPhoto(Request $request, $user)
    {
        $image = $request['photo'];
        $count = Photo::where('user_id', $user)->count();
        if ($count == 1){
            $thisPhoto = Photo::where('user_id', $user)->first();
            $thisPhoto->photo = $image;
            $thisPhoto->save();

            return (new Response('фото перезаписано', 200));
        }else{
            DB::transaction(function () use ($image, $user) {
                $this->photo = app(Photo::class);
                $this->photo->photo = $image;
                $this->photo->user_id = $user;
                $this->photo->save();

                return (new Response('фото записано', 200));
            });
        }
    }

    public function deletePhoto($user){
        $count = Photo::where('user_id', $user)->count();
        if ($count == 1){
                $photo = Photo::where('user_id', $user)->first();
                $default = Photo::where('id', 1)->first();

                $photo->photo = $default->photo;
                $photo->save();
        }
    }
}
