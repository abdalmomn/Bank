<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Service\Banking\TransactionService;

class TransactionDashboardController extends Controller
{
    protected $service;
    public function __construct(TransactionService $service)
    {
        $this->service = $service;
    }
}
