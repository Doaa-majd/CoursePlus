<?php

namespace App\Http\Controllers\Api\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Auth\MustVerifyEmail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    public function attemptLogin(Request $request)
    {
        if (!auth()->attempt($this->credentials($request))) {
            return false;
        }
        $user = auth()->user();
        if ($user instanceof MustVerifyEmail && !$user->hasVerifiedEmail()) {
            return false;
        }

        // set the user's token
        //$this->guard()->setToken($token);
        //$accessToken = $user->createToken('authToken')->accessToken;

        return true;
    }

    /**
     * @OA\Post(
     *      path="/api/login",
     *      tags={"Auth"},
     *      summary="Login",
     *      description="Login",
     *      @OA\RequestBody(
     *          @OA\JsonContent(
     *              @OA\Property(property="email", type="string"),
     *              @OA\Property(property="password", type="string")
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Success of operation",
     *          @OA\JsonContent(
     *              @OA\Property(property="token_type", type="string"),
     *              @OA\Property(property="access_token", type="string"),
     *              @OA\Property(property="token_expires_at", type="date"),
     *              @OA\Property(property="user_id", type="number")
     *          )
     *      )
     * )
     */
    protected function sendLoginResponse(Request $request)
    {
        $this->clearLoginAttempts($request);
        $user = Auth::user();
        $token = $user->createToken('authToken');
        return response()->json([
            'token_type' => 'bearer',
            'access_token' => $token->accessToken,
            'token_expires_at' => $token->token->expires_at,
            'user_id' => $user->id
        ]);
    }

    protected function sendFailedLoginResponse()
    {
        $user = $this->guard()->user();

        if ($user instanceof MustVerifyEmail && ! $user->hasVerifiedEmail()) {
            return response()->json(["errors" => [
                "message" => "You need to verify your email account"
            ]], 422);
        }

        throw ValidationException::withMessages([
            $this->username() => "Invalid credentials"
        ]);
    }

    public function logout(Request $request)
    {
        $this->validate($request, [
            'allDevice' => 'required'
        ]);

        $user = Auth::user();
        if ($request->allDevice) {
            $user->tokens->each(function ($token) {
                $token->delete();
            });
            return response(['message' => 'Logged out from all device!'], 200);
        }

        $userToken = $user->token();
        $userToken->delete();
        return response(['message' => 'Logged Successful !!'], 200);
    }
}
