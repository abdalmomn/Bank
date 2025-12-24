<?php

namespace App\Http\Service\Banking;

use App\Http\DTO\Transaction\TransactionApprovalDTO;
use App\Http\Helpers\ApplyTransferHelper;
use App\Models\Transaction;
use App\Models\TransactionApproval;
use App\Models\LedgerEntry;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Events\SendNotificationEvent;

class ApprovalService
{
    protected $helper;
    public function __construct(ApplyTransferHelper $helper)
    {
        $this->helper = $helper;
    }

    public function approveTransaction(TransactionApprovalDTO $dto, $transaction_id)
    {
        return DB::transaction(function () use ($dto,$transaction_id) {

            $transaction = Transaction::lockForUpdate()
                ->where('id', $transaction_id)
                ->where('requires_approval', true)
                ->where('status', 'pending')
                ->firstOrFail();
            $approval = TransactionApproval::updateOrCreate(
                ['transaction_id' => $transaction->id],
                [
                    'approver_id' => Auth::id(),
                    'decision' => $dto->decision,
                    'notes' => $dto->notes
                ]
            );

            if ($dto->decision === 'rejected') {
                $transaction->update(['status' => 'rejected']);

                event(new SendNotificationEvent(
                    user: $transaction->initiator,
                    title: 'Transaction Rejected',
                    message: 'Your transaction '.$transaction->reference.' was rejected',
                    type: 'error',
                    notifiable: $transaction
                ));

                return [
                    'data' => $transaction,
                    'message' => 'transaction rejected',
                    'code' => 200
                ];
            }

            $this->helper->applyTransactionEffect($transaction);

            $transaction->update([
                'status' => 'completed',
                'requires_approval' => false
            ]);

            event(new SendNotificationEvent(
                user: $transaction->initiator,
                title: 'Transaction Approved',
                message: 'Your transaction '.$transaction->reference.' was approved',
                type: 'success',
                notifiable: $transaction
            ));

            return [
                'data' => $transaction,
                'message' => 'transaction approved',
                'code' => 200
            ];
        });
    }


}
