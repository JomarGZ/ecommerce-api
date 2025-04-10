<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\ApiController;
use App\Http\Requests\Api\V1\LoginRequest;
use App\Models\User;
use Illuminate\Http\Request;

class LoginController extends ApiController
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(LoginRequest $request)
    {
        // find user by email
        $user = User::whereEmail('')
        // check user exist and password check
        //get device info
        // create token and return token
    }
}
