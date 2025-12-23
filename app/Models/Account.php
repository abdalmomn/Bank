<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Account extends Model
{
    use SoftDeletes, HasFactory;

    protected $fillable = [
        'account_number',
        'account_type_id',
        'customer_id',
        'parent_id',
        'user_id',
        'balance',
        'currency',
        'state',
        'metadata',
    ];

    protected $casts = [
        'balance' => 'decimal:4',
        'metadata' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function type()
    {
        return $this->belongsTo(AccountType::class);
    }

    public function parent()
    {
        return $this->belongsTo(Account::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Account::class, 'parent_id');
    }

    public function ledgerEntries()
    {
        return $this->hasMany(LedgerEntry::class);
    }

    public function outgoingTransactions()
    {
        return $this->hasMany(Transaction::class, 'from_account_id');
    }

    public function incomingTransactions()
    {
        return $this->hasMany(Transaction::class, 'to_account_id');
    }

    public function blacklist()
    {
        return $this->morphOne(Blacklist::class, 'blacklistable');
    }
}
