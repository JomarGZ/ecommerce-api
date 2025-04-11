<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;

class AuthenticatedUserController extends ApiController
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $user = $request->user()->load('permissions');

        return $this->success(
            [
            'user' => $user->only(['id', 'name', 'email']),
            'permissions' => $user->getALLPermissions()->pluck('name'),
            'role' => $user->getRoleNames()
            ],
            'Retrieved authenticated user data successfully',
        );
    }
}
