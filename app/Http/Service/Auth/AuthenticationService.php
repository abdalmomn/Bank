<?php

namespace App\Http\Service\Auth;

use App\Http\DTO\Auth\ActivationDTO;
use App\Http\DTO\Auth\LoginDTO;
use App\Http\DTO\Auth\ResetPasswordDTO;
use App\Models\Account;
use App\Models\OtpCode;
use Illuminate\Support\Facades\Hash;

class AuthenticationService
{
    public function activateAccount(ActivationDTO $dto)
    {
        $account = Account::where('account_number', $dto->account_number)->first();
        if (!$account){
            return [
                'data' => null,
                'message' => 'account not found',
                'code' => 404
            ];
        }
        $user = $account->customer->user;

        $otp = OtpCode::where('email', $user->email)
            ->where('otp_code', $dto->otp_code)
            ->where('expires_at', '>', now())
            ->first();

        if (!$otp) {
            return [
                'data' => null,
                'message' => 'invalid or expired otp',
                'code' => 400
            ];
        }

        if (!Hash::check($dto->password, $user->password)) {
            return [
                'data' => null,
                'message' => 'invalid password',
                'code' => 400
            ];
        }

        $user->update([
            'is_active' => true
        ]);

        return [
            'code' => 200,
            'message' => 'Account activated successfully',
            'data' => $user
        ];
    }

    public function resetPassword(ResetPasswordDTO $dto)
    {
        $account = Account::where('account_number', $dto->account_number)->first();
        if (!$account){
            return [
                'data' => null,
                'message' => 'account not found',
                'code' => 404
            ];
        }
        $user = $account->customer->user;

        if (! Hash::check($dto->old_password, $user->password)) {
            return[
                'data' => null,
                'message' => 'the old password is incorrect',
                'code' => 400
            ];
        }

        $user->update([
            'password' => Hash::make($dto->new_password)
        ]);

        return [
            'data' => $user,
            'message' => 'password changed successfully',
            'code' => 200
        ];
    }

    public function login(LoginDTO $dto)
    {
        $account = Account::where('account_number', $dto->account_number)->first();
        if (!$account){
            return [
                'data' => null,
                'message' => 'account not found',
                'code' => 404
            ];
        }
        $user = $account->customer->user;

        if (!$user->is_active || ! Hash::check($dto->password, $user->password)) {
            return[
                'data' => null,
                'message' => 'invalid credentials',
                'code' => 400
            ];
        }

        $token = $user->createToken('token')->plainTextToken;

        return [
            'data' => [
                'token' => $token,
                'user'  => $user,
                'account'  => $account,
                'roles' => $user->roles
            ],
            'message' => 'user logged in successfully',
            'code' => 200
        ];
    }

    public function logout()
    {
        auth()->user()->tokens()->delete();

        return [
            'data' => null,
            'message' => 'logged out successfully',
            'code' => 200
        ];
    }
}
