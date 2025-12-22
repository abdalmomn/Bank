<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Service\FaqService;

class FaqDashboardController extends Controller
{
    protected $service;
    public function __construct(FaqService $service)
    {
        $this->service = $service;
    }
}
