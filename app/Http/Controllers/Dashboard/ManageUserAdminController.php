<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Service\ManageUserService;

class ManageUserAdminController extends Controller
{
    protected $service;
    public function __construct(ManageUserService $service)
    {
        $this->service = $service;
    }
}
