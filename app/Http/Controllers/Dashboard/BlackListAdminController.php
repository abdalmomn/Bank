<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Service\BlackListService;

class BlackListAdminController extends Controller
{
    protected $service;
    public function __construct(BlackListService $service)
    {
        $this->service = $service;
    }
}
