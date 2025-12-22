<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Commission extends Model {
    use HasFactory;

    protected $fillable = [
        'code',
        'description',
        'fixed_amount',
        'percentage',
        'conditions',
        'is_active'
    ];
    protected $casts = [
        'conditions'=>'array',
        'is_active'=>'boolean'
    ];
}

