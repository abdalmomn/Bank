<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use App\Service\NotificationService;

class NotificationController extends Controller
{
    protected $service;
    public function __construct(NotificationService $service)
    {
        $this->service = $service;
    }
}
