<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blacklist extends Model {
    use HasFactory;

    protected $fillable = [
        'reason',
        'banned_at',
        'expires_at'
    ];

    protected $casts = [
        'banned_at'=>'datetime',
        'expires_at'=>'datetime'
    ];

    public function blacklistable() {
        return $this->morphTo();
    }
}

