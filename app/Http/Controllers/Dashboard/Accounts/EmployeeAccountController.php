<?php

namespace App\Http\Controllers\Dashboard\Accounts;

use App\Http\Controllers\Controller;
use App\Http\DTO\Account\UserDTO;
use App\Http\Requests\Accounts\EmployeeRequest;
use App\Http\Resources\User\DashboardUserDetailsResource;
use App\Http\Resources\User\UserDetailsResource;
use App\Http\Resources\User\UserLightResource;
use App\Http\Service\Banking\AccountService;

class EmployeeAccountController extends Controller
{
    protected $service;
    public function __construct(AccountService $service)
    {
        $this->service = $service;
    }

    public function store(EmployeeRequest $request)
    {
        $dto = UserDTO::fromArray($request->validated());

        $data = $this->service->createEmployee($dto);

        if ($data['data'] === null) {
            return response()->json([
                'data' => null,
                'message' => $data['message'],
                'code' => $data['code'],
            ]);
        }

        // استخراج البيانات من مصفوفة الـ Service
        $user = $data['data']['user'];
        $account = $data['data']['account'];

        return response()->json([
            // نمرر الـ User للـ Resource، ونلحق الـ Account بالبيانات الإضافية
            'data' => (new UserDetailsResource($user))->additional(['account' => $account]),
            'message' => $data['message'],
            'code' => $data['code']
        ]);
    }

    public function index()
    {
        $data = $this->service->show_all_employees();
        return response()->json([
            'data' => UserLightResource::collection($data['data']),
            'message' => $data['message'],
            'code' => $data['code']
        ]);
    }

    public function show( $userId)
    {
        $data = $this->service->show_employee_details($userId);
        return response()->json([
            'data' => $data['data'] ? new UserDetailsResource($data['data']) : null,
            'message' => $data['message'],
            'code' => $data['code']
        ]);
    }

    public function update( $userId, EmployeeRequest $request)
    {
        $validated_data = UserDTO::fromArray($request->validated());
        $data = $this->service->update_employee($userId, $validated_data);
        return response()->json([
            'data' => $data['data'] ? new UserDetailsResource($data['data']) : null,
            'message' => $data['message'],
            'code' => $data['code']
        ]);
    }

    public function destroy( $userId)
    {
        $data = $this->service->delete_employee($userId);
        return response()->json($data);
    }

}
