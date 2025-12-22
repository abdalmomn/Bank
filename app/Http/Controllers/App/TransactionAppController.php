<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use App\Http\Service\Banking\TransactionService;

class TransactionAppController extends Controller
{
    protected $service;
    public function __construct(TransactionService $service)
    {
        $this->service = $service;
    }
}
