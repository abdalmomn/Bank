<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Service\Customer\CostumerService;

class CostumerEmployeeController extends Controller
{
    protected $service;
    public function __construct(CostumerService $service)
    {
        $this->service = $service;
    }
}
