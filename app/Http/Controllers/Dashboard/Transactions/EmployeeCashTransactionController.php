<?php

namespace App\Http\Controllers\Dashboard\Transactions;

use App\Http\Controllers\Controller;
use App\Http\DTO\Transaction\CashOperationDTO;
use App\Http\DTO\Transaction\TransferDTO;
use App\Http\Requests\Transactions\DepositRequest;
use App\Http\Requests\Transactions\TransferRequest;
use App\Http\Requests\Transactions\WithdrawRequest;
use App\Http\Resources\Transaction\TransactionResource;
use App\Http\Service\Banking\CashTransactionService;

class EmployeeCashTransactionController extends Controller
{
    protected $service;

    public function __construct(
        CashTransactionService $service
    ) {
        $this->service = $service;
    }

    public function deposit(DepositRequest $request)
    {
        $dto = CashOperationDTO::fromArray($request->validated());
        $data = $this->service->deposit($dto);
        if ($data['data'] === null) {
            return response()->json([
                'data' => null,
                'message' => $data['message'],
                'code' => $data['code'],
            ], $data['code']);
        }
        return response()->json([
            'data' => new TransactionResource($data['data']),
            'message' => $data['message'],
            'code' => $data['code']
        ]);
    }

    public function withdraw(WithdrawRequest $request)
    {
        $dto = CashOperationDTO::fromArray($request->validated());
        $data = $this->service->withdraw($dto);
        if ($data['data'] === null) {
            return response()->json([
                'data' => null,
                'message' => $data['message'],
                'code' => $data['code'],
            ], $data['code']);
        }
        return response()->json([
            'data' => new TransactionResource($data['data']),
            'message' => $data['message'],
            'code' => $data['code']
        ]);
    }

    public function transfer(TransferRequest $request)
    {
        $dto = new TransferDTO($request->validated());

        $data = $this->service->transfer($dto);

        if ($data['data'] === null) {
            return response()->json([
                'data' => null,
                'message' => $data['message'],
                'code' => $data['code'],
            ], $data['code']);
        }
        return response()->json([
            'data' => new TransactionResource($data['data']),
            'message' => $data['message'],
            'code' => $data['code']
        ]);
    }
}
