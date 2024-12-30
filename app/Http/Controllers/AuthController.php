<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Jobs\SendEmail;
use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\RegisterRequest;

class AuthController extends Controller
{
    public function register(RegisterRequest $request){
      $user = new User();
      $user->name = $request->name;
      $user->email = $request->email;
      $user->verification_token = uniqid();
      $user->password = bcrypt($request->password);
      $imagePath = null;
      $user->phone_number = $request->phone_number;
      if ( $request->role) {
        $user->role = $request->role;
    }
      $user->save();
      if ($request->hasFile('image')) {
          $imagePath = $this->uploadImage($request->file('image'), 'user');
      }
      $user->images()->create([
        'image'=> $imagePath,
      ]); 
      SendEmail::dispatch($user);
      return $this->success(new UserResource($user->load('images')),__("messages.register"));
    }
    public function emailVerify(Request $request)
    {
        $user = User::where('verification_token', $request->token)->first();
        if (!$user || $user->verification_token !== $request->token) {
            return $this->error(__('messages.verify'), 404);
        }
        $user->email_verified_at = now();
        $user->save();
        return $this->success([new UserResource($user)],__('messages.email'));
    }
   public function login(LoginRequest $request){
   $user = User::where("email", $request->email)->first();
   if($user->email_verified_at === null){
    return $this->error(__("messages.verify"));
   }
   if (Hash::check($request->password, $user->password)) {
    $user->tokens()->delete();
    $token = $user->createToken('auth_login')->plainTextToken;
    return $this->success([
     'user' =>   new UserResource($user->load('images')),
     'token' => $token,
   ] ,__('messages.login'));
}
   }
   public function logout(Request $request){
    if (!$request->user() || !$request->user()->currentAccessToken()) {
        return $this->error(__('messages.logouted'));
    }
    $request->user()->currentAccessToken()->delete();
    return $this->success([], __('messages.logout'));
}
   public function findUser(Request $request){
    $user = $request->user();
    if (!$user) {
        return $this->error(__('messages.userNotFound'), 401);
    }

    return $this->success(new UserResource($user), __('messages.userFound'));
}
}
