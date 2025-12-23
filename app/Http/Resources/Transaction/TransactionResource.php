<?php

namespace App\Http\Resources\Transaction;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TransactionResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'reference' => $this->reference,
            'type' => $this->type,
            'status' => $this->status,
            'amount' => $this->amount,
            'currency' => $this->currency,
            'requires_approval' => $this->requires_approval,
            'from_account_id' => $this->from_account_id,
            'to_account_id' => $this->to_account_id,
            'initiated_by' => $this->initiator_id,
            'created_at' => $this->created_at,
        ];
    }
}
