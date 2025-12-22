<?php

namespace App\Http\Controllers\Dashboard\Auth;

use App\Http\Controllers\Controller;
use App\Http\DTO\Auth\LoginDTO;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Resources\User\DashboardUserDetailsResource;
use App\Http\Resources\User\UserDetailsResource;
use App\Http\Service\Auth\AuthenticationService;

class DashboardAuthController extends Controller
{
    public function __construct(
        protected AuthenticationService $authService
    ) {}

    public function login(LoginRequest $request)
    {
        $dto = LoginDTO::fromArray($request->validated());
        $data = $this->authService->login($dto);
        if ($data['data'] === null) {
            return response()->json([
                'data' => null,
                'message' => $data['message'],
                'code' => $data['code'],
            ], $data['code']);
        }
        return response()->json([
            'data' => [
                'token' => $data['data']['token'],
                'user'  => new DashboardUserDetailsResource($data['data']['user']) ?? null,
            ],
            'message' => $data['message'],
            'code' => $data['code']
        ]);

    }

    public function logout()
    {
        $data = $this->authService->logout();

        return response()->json([
            'data' => null,
            'message' => $data['message'],
            'code' => $data['code']
        ]);
    }
}
