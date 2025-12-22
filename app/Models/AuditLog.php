<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuditLog extends Model {
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'entity_type',
        'entity_id',
        'action',
        'before',
        'after',
        'user_id',
        'ip'

    ];
    protected $casts = [
        'before'=>'array',
        'after'=>'array'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}

