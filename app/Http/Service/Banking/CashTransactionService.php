<?php

namespace App\Http\Service\Banking;

use App\Domain\Transactions\Fees\FeeStrategyFactory;
use App\Domain\Transactions\States\TransactionStateFactory;
use App\Http\DTO\Transaction\CashOperationDTO;
use App\Http\DTO\Transaction\TransferDTO;
use App\Models\Account;
use App\Models\LedgerEntry;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;

class CashTransactionService
{
    public function deposit(CashOperationDTO $dto)
    {
        return DB::transaction(function () use ($dto) {
            try {
                $account = Account::where('account_number', $dto->accountNumber)
                    ->lockForUpdate()
                    ->firstOrFail();

                if ($account->state !== 'active') {
                    return [
                        'data' => null,
                        'message' => 'Account is not active',
                        'code' => 400
                    ];
                }

                $transaction = Transaction::create([
                    'reference' => 'DEP-' . now()->timestamp,
                    'to_account_id' => $account->id,
                    'from_account_id' => $account->id,
                    'amount' => $dto->amount,
                    'currency' => $account->currency,
                    'type' => 'deposit',
                    'initiator_id' => auth()->id(),
                ]);
                $feeStrategy = FeeStrategyFactory::make('deposit');
                $fee = $feeStrategy->calculate($dto->amount, $transaction);

                $transaction->update([
                    'fee' => $fee,
                    'net_amount' => $dto->amount - $fee,
                ]);

                $state = TransactionStateFactory::make($dto->amount);
                $state->apply($transaction, $dto->amount);

                // إنشاء الـ Ledger
                LedgerEntry::create([
                    'transaction_id' => $transaction->id,
                    'account_id' => $account->id,
                    'entry_type' => 'debit',
                    'amount' => $fee,
                    'currency' => $account->currency,
                    'narration' => $dto->narration ?? 'Cash deposit',
                ]);

                if (!$transaction->requires_approval) {
                    $account->increment('balance', $dto->amount - $fee);
                }

                $message = $transaction->requires_approval
                    ? 'Deposit is pending for approval'
                    : 'Deposit completed successfully';
                return [
                    'data' => $transaction,
                    'message' => $message,
                    'code' => 200
                ];
            }catch (\Exception $e) {
                $transaction ??= Transaction::create([
                    'reference' => 'DEP-' . now()->timestamp,
                    'from_account_id' => null,
                    'to_account_id' => null,
                    'amount' => $dto->amount,
                    'currency' => 'USD',
                    'type' => 'deposit',
                    'initiator_id' => auth()->id(),
                ]);
                TransactionStateFactory::failed()->apply($transaction, $dto->amount);
                return ['data' => null, 'message' => $e->getMessage(), 'code' => 400];
            }
        });
    }

    public function withdraw(CashOperationDTO $dto)
    {
        return DB::transaction(function () use ($dto) {
            try {
                $account = Account::where('account_number', $dto->accountNumber)
                ->lockForUpdate()
                ->firstOrFail();

            if ($account->state !== 'active') {
                return [
                    'data' => null,
                    'message' => 'Account is not active',
                    'code' => 400
                ];
            }

            if ($account->balance < $dto->amount) {
                return [
                    'data' => null,
                    'message' => 'Insufficient balance',
                    'code' => 400
                ];
            }

            $transaction = Transaction::create([
                'reference' => 'WDR-' . now()->timestamp,
                'from_account_id' => $account->id,
                'amount' => $dto->amount,
                'currency' => $account->currency,
                'type' => 'withdraw',
                'initiator_id' => auth()->id(),
            ]);

            $feeStrategy = FeeStrategyFactory::make('withdraw');
            $fee = $feeStrategy->calculate($dto->amount, $transaction);

            $totalDebit = $dto->amount + $fee;

            if ($account->balance < $totalDebit) {
                return [
                    'data' => null,
                    'message' => 'Insufficient balance including fees',
                    'code' => 400
                ];
            }

            $state = TransactionStateFactory::make($dto->amount);
            $state->apply($transaction, $dto->amount);

            LedgerEntry::create([
                'transaction_id' => $transaction->id,
                'account_id' => $account->id,
                'entry_type' => 'debit',
                'amount' => $dto->amount,
                'currency' => $account->currency,
                'narration' => $dto->narration ?? 'Cash withdrawal',
            ]);

            if (!$transaction->requires_approval) {
                $account->decrement('balance', $totalDebit);
            }


                $message = $transaction->requires_approval
                ? 'Withdrawal is pending for approval'
                : 'Withdrawal completed successfully';

            return [
                'data' => $transaction,
                'message' => $message,
                'code' => 200
            ];
            } catch (\Exception $e) {
                $transaction ??= Transaction::create([
                    'reference' => 'WDR-' . now()->timestamp,
                    'from_account_id' => null,
                    'amount' => $dto->amount,
                    'currency' => 'USD',
                    'type' => 'withdraw',
                    'initiator_id' => auth()->id(),
                ]);
                TransactionStateFactory::failed()->apply($transaction, $dto->amount);
                return ['data' => null, 'message' => $e->getMessage(), 'code' => 400];
            }
        });
    }


    public function transfer(TransferDTO $dto)
    {
        return DB::transaction(function () use ($dto) {
            try {

            $fromAccount = Account::where('account_number', $dto->fromAccountNumber)
                ->lockForUpdate()
                ->firstOrFail();

            $toAccount = Account::where('account_number', $dto->toAccountNumber)
                ->lockForUpdate()
                ->firstOrFail();

            if ($fromAccount->state !== 'active') {
                return [
                    'data' => null,
                    'message' => 'Account is not active',
                    'code' => 400
                ];
            }

            if ($fromAccount->balance < $dto->amount) {
                return [
                    'data' => null,
                    'message' => 'Insufficient balance',
                    'code' => 400
                ];
            }


            $transaction = Transaction::create([
                'reference' => 'TRF-' . now()->timestamp,
                'from_account_id' => $fromAccount->id,
                'to_account_id' => $toAccount->id,
                'amount' => $dto->amount,
                'currency' => $fromAccount->currency,
                'type' => 'transfer',
                'initiator_id' => auth()->id(),
            ]);
                $feeStrategy = FeeStrategyFactory::make('transfer');
                $fee = $feeStrategy->calculate($dto->amount, $transaction);

                $totalDebit = $dto->amount + $fee;

                if ($fromAccount->balance < $totalDebit) {
                    return [
                        'data' => null,
                        'message' => 'Insufficient balance including fees',
                        'code' => 400
                    ];
                }


            $state = TransactionStateFactory::make($dto->amount);
            $state->apply($transaction, $dto->amount);

            // Ledger debit
            LedgerEntry::create([
                'transaction_id' => $transaction->id,
                'account_id' => $fromAccount->id,
                'entry_type' => 'debit',
                'amount' => $dto->amount,
                'currency' => $fromAccount->currency,
                'narration' => $dto->narration ?? 'Transfer to another account',
            ]);

            // Ledger credit
            LedgerEntry::create([
                'transaction_id' => $transaction->id,
                'account_id' => $toAccount->id,
                'entry_type' => 'credit',
                'amount' => $dto->amount,
                'currency' => $toAccount->currency,
                'narration' => $dto->narration ?? 'Transfer from another account',
            ]);

            if (!$transaction->requires_approval) {
                $fromAccount->decrement('balance', $totalDebit);
                $toAccount->increment('balance', $dto->amount);
            }


            $message = $transaction->requires_approval
            ? 'Transfer is pending for approval'
            : 'Transfer completed successfully';

            return [
                'data' => $transaction,
                'message' => $message,
                'code' => 200,
            ];
            } catch (\Exception $e) {
                $transaction ??= Transaction::create([
                    'reference' => 'TRF-' . now()->timestamp,
                    'from_account_id' => null,
                    'to_account_id' => null,
                    'amount' => $dto->amount,
                    'currency' => 'USD',
                    'type' => 'transfer',
                    'initiator_id' => auth()->id(),
                ]);
                TransactionStateFactory::failed()->apply($transaction, $dto->amount);
                return ['data' => null, 'message' => $e->getMessage(), 'code' => 400];
            }
        });
    }
}
