<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\ApiController;
use App\Http\Requests\Api\V1\StoreRegisterRequest;
use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class RegisterController extends ApiController
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(StoreRegisterRequest $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        $device = substr($request->header('User-Agent') ?? 'Uknown', 0, 255);
        return $this->success(
                ['access_token' => $user->createToken($device)->plainTextToken],
            'User created successfully',
            Response::HTTP_CREATED
        );
    }
    
}
