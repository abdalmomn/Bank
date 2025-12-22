<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use SoftDeletes, HasFactory;

    protected $fillable = [
        'user_id',
        'first_name',
        'father_name',
        'last_name',
        'national_id',
        'birth_date',
        'birth_place',
        'nationality',
        'mother_name',
        'age',
        'address',
        'phone',
        'email',
        'occupation',
        'education_level',
        'monthly_income',
        'monthly_expenses',
        'kyc_status',
        'metadata',
    ];

    protected $casts = [
        'birth_date' => 'date',
        'monthly_income' => 'decimal:2',
        'monthly_expenses' => 'decimal:2',
        'metadata' => 'array',
    ];

    /* ================= Relations ================= */

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function auditLogs()
    {
        return $this->morphMany(AuditLog::class, 'entity');
    }

    public function accounts()
    {
        return $this->hasMany(Account::class);
    }

    public function blacklist()
    {
        return $this->morphOne(Blacklist::class, 'blacklistable');
    }

    /* ================= Accessors ================= */

    public function getFullNameAttribute()
    {
        return trim("{$this->first_name} {$this->last_name}");
    }

    /* ================= Scopes ================= */

    public function scopeVerified($query)
    {
        return $query->where('kyc_status', 'verified');
    }
}
