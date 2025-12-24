<?php

namespace App\Http\Controllers\Dashboard\Transactions;

use App\Http\Controllers\Controller;
use App\Http\DTO\Transaction\TransactionApprovalDTO;
use App\Http\Requests\Transactions\TransactionApprovalRequest;
use App\Http\Resources\Transaction\TransactionResource;
use App\Http\Service\Banking\ApprovalService;

class TransactionApprovalController extends Controller
{
    protected $service;
    public function __construct(ApprovalService $service)
    {
        $this->service = $service;
    }

    public function approve(TransactionApprovalRequest $request,$transaction_id)
    {
        $dto = TransactionApprovalDTO::fromArray($request->validated());

        $data = $this->service->approveTransaction($dto,$transaction_id);
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
