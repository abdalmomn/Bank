<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Transaction extends Model
{
    use HasFactory;


    protected $fillable = [
        'reference',
        'from_account_id',
        'to_account_id',
        'amount',
        'currency',
        'type',
        'fees',
        'status',
        'initiator_id',
        'requires_approval',
        'metadata',
    ];

    protected $casts = [
        'amount' => 'decimal:4',
        'requires_approval' => 'boolean',
        'metadata' => 'array',
    ];


    /* ================= Relations ================= */

    public function fromAccount()
    {
        return $this->belongsTo(Account::class, 'from_account_id');
    }

    public function toAccount()
    {
        return $this->belongsTo(Account::class, 'to_account_id');
    }

    public function initiator()
    {
        return $this->belongsTo(User::class, 'initiator_id');
    }

    public function ledgerEntries()
    {
        return $this->hasMany(LedgerEntry::class);
    }

    public function approvals()
    {
        return $this->hasMany(TransactionApproval::class);
    }
}
