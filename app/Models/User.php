<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable, HasRoles, SoftDeletes, HasFactory;

    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'profile',
        'is_active',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'profile' => 'array',
        'is_active' => 'boolean',
    ];

    /* ========= Relations ========= */

    public function deviceTokens()
    {
        return $this->hasMany(DeviceToken::class);
    }

    public function accounts()
    {
        return $this->hasMany(Account::class);
    }

    public function customer()
    {
        return $this->hasOne(Customer::class);
    }

    public function initiatedTransactions()
    {
        return $this->hasMany(Transaction::class, 'initiator_id');
    }

    public function approvals()
    {
        return $this->hasMany(TransactionApproval::class, 'approver_id');
    }

    public function auditLogs()
    {
        return $this->hasMany(AuditLog::class);
    }

    // creator relations
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function createdUsers()
    {
        return $this->hasMany(User::class, 'created_by');
    }

    // blacklist
    public function blacklist()
    {
        return $this->morphOne(Blacklist::class, 'blacklistable');
    }

    /* ========= Scopes ========= */

    public function scopeActive($q)
    {
        return $q->where('is_active', true);
    }
}
