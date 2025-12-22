<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use App\Http\Service\Banking\AccountService;

class AccountAppController extends Controller
{
    protected $service;
    public function __construct(AccountService $service)
    {
        $this->service = $service;
    }
}
