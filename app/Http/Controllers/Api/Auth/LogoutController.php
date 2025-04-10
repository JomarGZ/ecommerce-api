<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;

class LogoutController extends ApiController
{
    public function __invoke(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return $this->success('', 'Logged out successfully');
    }
}
