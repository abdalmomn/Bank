<?php

namespace App\Http\Controllers\Dashboard\Accounts;

use App\Http\Controllers\Controller;
use App\Http\DTO\Account\CustomerAccountDTO;
use App\Http\Requests\Accounts\CustomerAccountRequest;
use App\Http\Resources\User\UserAppDetailsResource;
use App\Http\Resources\User\UserDetailsResource;
use App\Http\Resources\User\UserLightResource;
use App\Http\Service\Banking\AccountService;
use App\Http\Service\Customer\CostumerService;

class CostumerAccountController extends Controller
{
    protected $service;
    public function __construct(AccountService $service)
    {
        $this->service = $service;
    }

    public function store(CustomerAccountRequest $request)
    {
        $dto = CustomerAccountDTO::fromArray($request->validated());

        $data = $this->service->createCustomerAccount($dto);

        return response()->json([
            'data' => new UserAppDetailsResource($data['data']),
            'message' => $data['message'],
            'code' => $data['code']
        ]);
    }

    public function index()
    {
        $data = $this->service->show_all_customers();
        return response()->json([
            'data' => UserLightResource::collection($data['data']),
            'message' => $data['message'],
            'code' => $data['code']
        ]);
    }

    public function show( $userId)
    {
        $data = $this->service->show_customer_details($userId);
        return response()->json([
            'data' => $data['data'] ? new UserAppDetailsResource($data['data']) : null,
            'message' => $data['message'],
            'code' => $data['code']
        ]);
    }

    public function update( $userId, CustomerAccountRequest $request)
    {
        $validated_data = CustomerAccountDTO::fromArray($request->validated());
        $data = $this->service->update_customer($userId, $validated_data);
        return response()->json([
            'data' => $data['data'] ? new UserAppDetailsResource($data['data']) : null,
            'message' => $data['message'],
            'code' => $data['code']
        ]);
    }

    public function destroy( $userId)
    {
        $data = $this->service->delete_customer($userId);
        return response()->json($data);
    }
}
