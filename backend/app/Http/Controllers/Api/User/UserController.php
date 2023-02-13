<?php

namespace App\Http\Controllers\Api\User;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

final class UserController
{
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function user(Request $request)
    {
        return new JsonResponse(['code' => 200, 'message' => $request->user()]);
    }

}
