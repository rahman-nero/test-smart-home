<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Auth\SignUpRequest;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;

final class SignUpController extends Controller
{
    private UserService $service;

    /**
     * @param UserService $service
     */
    public function __construct(UserService $service)
    {
        $this->service = $service;
    }

    /**
     * @param SignUpRequest $request
     * @return JsonResponse
     */
    public function signup(SignUpRequest $request)
    {
        $name = $request->input('name');
        $email = $request->input('email');
        $password = $request->input('password');

        $user = $this->service->create(name: $name, email: $email, password: $password);

        $token = $user->createToken('token_authenticate');

        return new JsonResponse(['code' => 200, 'message' =>
            [
                'token' => $token->plainTextToken
            ]
        ]);
    }

}
