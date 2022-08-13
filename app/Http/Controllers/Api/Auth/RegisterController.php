<?php

namespace App\Http\Controllers\Api\Auth;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use App\Http\Requests\Api\Auth\RegisterRequest;

class RegisterController extends Controller
{

    public function create(RegisterRequest $request)
    {
        $data = $request->validated();
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password'])
        ]);
        $token = $user->createToken('authToken');
        event(new Registered($user));
        return response()->json([
            'access_token' => $token->accessToken,
            'token_expires_at' => $token->token->expires_at,
            'user_id' => $user->id
        ], 200);
    }
}
