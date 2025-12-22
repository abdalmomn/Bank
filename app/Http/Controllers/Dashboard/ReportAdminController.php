<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Service\ReportService;

class ReportAdminController extends Controller
{
    protected $service;
    public function __construct(ReportService $service)
    {
        $this->service = $service;
    }
}
