<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionApproval extends Model
{
    use HasFactory;

    protected $fillable = [
        'transaction_id',
        'approver_id',
        'decision',
        'notes',
    ];

    public function approver()
    {
        return $this->belongsTo(User::class, 'approver_id');
    }
    public function transaction()
    {
        return $this->belongsTo(Transaction::class, 'transaction_id', 'id');
    }

}
