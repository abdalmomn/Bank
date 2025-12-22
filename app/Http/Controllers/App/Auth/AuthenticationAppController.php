<?php

namespace App\Http\Controllers\App\Auth;

use App\Http\Controllers\Controller;
use App\Http\DTO\Auth\ActivationDTO;
use App\Http\DTO\Auth\LoginDTO;
use App\Http\DTO\Auth\ResetPasswordDTO;
use App\Http\Requests\Auth\ActivateAccountRequest;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\ResetPasswordRequest;
use App\Http\Resources\User\UserAppDetailsResource;
use App\Http\Resources\User\UserDetailsResource;
use App\Http\Resources\User\UserLightResource;
use App\Http\Service\Auth\AuthenticationService;
use Illuminate\Http\Request;

class AuthenticationAppController extends Controller
{
    public function __construct(
        protected AuthenticationService $authService
    ) {}

    public function activateAccount(ActivateAccountRequest $request)
    {
        $dto = ActivationDTO::fromArray($request->validated());
        $data = $this->authService->activateAccount($dto);
        if ($data['data'] === null) {
            return response()->json([
                'data' => null,
                'message' => $data['message'],
                'code' => $data['code'],
            ], $data['code']);
        }
        return response()->json([
           'data' => new UserLightResource($data['data']),
           'message' => $data['message'],
           'code' => $data['code']
        ]);
    }


    public function resetPassword(ResetPasswordRequest $request)
    {
        $dto = ResetPasswordDTO::fromArray($request->validated());
        $data = $this->authService->resetPassword($dto);
        if ($data['data'] === null) {
            return response()->json([
                'data' => null,
                'message' => $data['message'],
                'code' => $data['code'],
            ], $data['code']);
        }
        return response()->json([
            'data' => new UserLightResource($data['data']),
            'message' => $data['message'],
            'code' => $data['code']
        ]);
    }

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
                'user'  => new UserAppDetailsResource($data['data']['user']) ?? null,
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
