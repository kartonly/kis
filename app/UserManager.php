<?php


namespace App;


use App\Models\Photo;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class UserManager
{
    private ?User $user;

    public function __construct(?User $user = null)
    {
        $this->user = $user;
    }

    public function create(array $data): ?User
    {
        DB::transaction(function () use ($data) {
            $this->user=app(User::class);
            $this->user->fill($data);
            $this->user->password = Hash::make($data['password']);
            $this->user->save();
        });

        return $this->user;
    }

    public function auth($email, $password, $remember)
    {
        $this->user = User::where('email', $email)->first();

        if(!$this->user){
            Log::info('User failed to login');
        }

        if(!Hash::check($password, optional($this->user)->password)){
            Log::info('User failed to login');
        }

        $ttl = env('JWT_TTL');
        if ($remember == true)
        {
            $ttl = env('JWT_REMEMBER_TTL');
        }

        return auth()->setTTL($ttl)->login($this->user);
    }

    public function logout(){
        auth()->logout();
    }

    public function update(array $params): User
    {
        if (isset($params['password'])){
            $params['password'] = Hash::make($params['password']);
        }
        $this->user->update($params);
        return $this->user;
    }

    public function updateAvatar(Photo $file): Photo
    {
        if ($this->user->photo)
        {
            $avatar = $this->user->photo;
            $this->user->photo()->associate(null);
            $this->user->save();

            app(PhotoManager::class, ['file' => $avatar])->delete();
        }

        $file = app(FileManager::class)->store($file, $this->user);
        $this->user->photo()->associate($file);
        $this->user->save();

        return $file;
    }

    public function updateMedia($file){
        $this->user->addMediaFromRequest('avatar')->toMediaCollection('avatars');
    }

    public function delete(){
        $this->user->delete();
    }

}
