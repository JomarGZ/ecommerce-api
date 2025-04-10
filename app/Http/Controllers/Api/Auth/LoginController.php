<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\ApiController;
use App\Http\Requests\Api\V1\LoginRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class LoginController extends ApiController
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(LoginRequest $request)
    {
        // find user by email
        $user = User::whereRaw('BINARY email = ?', [$request->email])->first();
        // check user exist and password check
        if (! $user || ! Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials is incorrect!']
            ]);
        }
        //get device info
        $device = substr($request->header('User-Agent') ?? 'Unknown', 0, 255);
        // create token and return token

        return $this->success(
            ['access_token' => $user->createToken($device)->plainTextToken],
            'Login Successfully'
        );
    }
}
