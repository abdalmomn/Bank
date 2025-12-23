<?php

namespace App\Http\Service\Banking;

use App\Events\SendEmailEvent;
use App\Events\SendNotificationEvent;
use App\Http\DTO\Account\UserDTO;
use App\Models\OtpCode;
use App\Models\User;
use App\Models\Customer;
use App\Models\Account;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use App\Http\DTO\Account\CustomerAccountDTO;

class AccountService
{

    public function createCustomerAccount(CustomerAccountDTO $dto)
    {
        return DB::transaction(function () use ($dto) {

            $tempPassword = Str::random(8);

            $user = User::create([
                'name'     => $dto->first_name.' '.$dto->last_name,
                'phone'    => $dto->phone,
                'email'    => $dto->email,
                'password' => Hash::make($tempPassword),
                'is_active'=> false,
                'created_by' => Auth::id()
            ]);

            $user->assignRole('customer');

            $customer = Customer::create(array_merge((array)$dto, ['user_id' => $user->id]));

            $account = Account::create([
                'account_number'  => 'ACC'.rand(100000,999999),
                'account_type_id' => $dto->account_type_id,
                'customer_id'     => $customer->id,
                'currency'        => $dto->currency,
            ]);
            $otp = rand(100001, 999999);
            OtpCode::query()->create([
                'email' => $user->email,
                'otp_code' => $otp,
                'expires_at' => now()->addMinutes(15)
            ]);
            event(new SendEmailEvent($user, $account, $tempPassword,$otp));

            return [
                'data' => $user , $customer, $account,
                'message' => 'customer created successfully',
                'code' => 200
            ];
        });
    }

    public function createEmployee(UserDTO $dto)
    {
        $user = User::create(array_merge((array)$dto,
        [
            'is_active' => true,
            'created_by' => Auth::id()
        ]));

        $user->assignRole('employee');

        $account = Account::create([
            'account_number'  => 'ACC'.rand(100000,999999),
            'account_type_id' => $dto->account_type_id,
            'user_id' => $user->id,
            'currency'        => 'SYP',
        ]);

        return [
            'data' => [
                'user' => $user,
                'account' => $account,
            ],            'message' => 'employee created successfully',
            'code' => 200
        ];
    }


    public function show_all_customers()
    {
        $customers = User::role('customer')->with('customer.accounts', 'roles')->get();

        return [
            'data' => $customers,
            'message' => 'all customers retrieved successfully',
            'code' => 200
        ];
    }

    public function show_customer_details( $userId)
    {
        $user = User::query()->with('customer.accounts.type')->find($userId);
        if (!$user) {
            return [
                'data' => null,
                'message' => 'customer not found',
                'code' => 404
            ];
        }
        return [
            'data' => $user,
            'message' => 'customer details retrieved successfully',
            'code' => 200
        ];
    }

    public function update_customer($userId, CustomerAccountDTO $dto)
    {
        $user = User::with('customer.accounts')->find($userId);
        if (!$user) {
            return [
                'data' => null,
                'message' => 'customer not found',
                'code' => 404
            ];
        }

        // تحديث بيانات User الأساسية
        $user->update([
            'name'  => $dto->first_name . ' ' . ($dto->last_name ?? ''),
            'phone' => $dto->phone,
            'email' => $dto->email,
        ]);

        // تحديث بيانات Customer التفصيلية
        $user->customer()->update([
            'father_name'      => $dto->father_name,
            'last_name'        => $dto->last_name,
            'national_id'      => $dto->national_id,
            'birth_date'       => $dto->birth_date,
            'birth_place'      => $dto->birth_place,
            'nationality'      => $dto->nationality,
            'mother_name'      => $dto->mother_name,
            'age'              => $dto->age,
            'address'          => $dto->address,
            'occupation'       => $dto->occupation,
            'education_level'  => $dto->education_level,
            'monthly_income'   => $dto->monthly_income,
            'monthly_expenses' => $dto->monthly_expenses,
        ]);

        foreach ($user->customer->accounts as $account) {
            $account->update([
                'currency'        => $dto->currency,
                'account_type_id' => $dto->account_type_id,
            ]);
        }

        return [
            'data' => $user,
            'message' => 'customer updated successfully',
            'code' => 200
        ];
    }


    public function delete_customer( $userId)
    {
        $user = User::query()->with('customer.accounts')->find($userId);
        if (!$user) {
            return [
                'data' => null,
                'message' => 'customer not found',
                'code' => 404
            ];
        }

        $user->delete();
        return [
            'data' => null,
            'message' => 'customer deleted successfully',
            'code' => 200
        ];
    }

    public function show_all_employees()
    {
        $employees = User::role('employee')->with('customer.accounts', 'roles')->get();


        return [
            'data' => $employees,
            'message' => 'all employees retrieved successfully',
            'code' => 200
        ];
    }

    public function show_employee_details($userId)
    {
        $user = User::role('employee')
            ->with(['roles', 'accounts.type'])
            ->find($userId);

        if (!$user) {
            return [
                'data' => null,
                'message' => 'employee not found',
                'code' => 404
            ];
        }

        return [
            'data' => $user,
            'message' => 'employee details retrieved successfully',
            'code' => 200
        ];
    }


    public function update_employee($userId, UserDTO $dto)
    {
        $user = User::role('employee')->find($userId);
        if (!$user) {
            return [
                'data' => null,
                'message' => 'employee not found',
                'code' => 404
            ];
        }

        $user->update([
            'name'     => $dto->name,
            'email'    => $dto->email,
            'phone'    => $dto->phone,
            'password' => Hash::make($dto->password),
            'profile'  => $dto->profile,
        ]);

        // تحديث نوع الحساب إذا Employee عنده علاقة بـ Account
        if ($user->customer && $user->customer->accounts()->exists()) {
            $user->customer->accounts()->update([
                'account_type_id' => $dto->account_type_id,
            ]);
        }

        return [
            'data' => $user,
            'message' => 'employee updated successfully',
            'code' => 200
        ];
    }


    public function delete_employee( $userId)
    {
        $user = User::role('employee')->find($userId);
        if (!$user) {
            return [
                'data' => null,
                'message' => 'employee not found',
                'code' => 404
            ];
        }

        $user->delete();
        return [
            'data' => null,
            'message' => 'employee deleted successfully',
            'code' => 200
        ];
    }

}
