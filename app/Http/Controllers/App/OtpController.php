<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use App\Service\OtpService;

class OtpController extends Controller
{
    protected $service;
    public function __construct(OtpService $service)
    {
        $this->service = $service;
    }
}
