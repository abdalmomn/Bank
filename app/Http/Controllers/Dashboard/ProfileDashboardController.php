<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Service\ProfileService;
use Illuminate\Http\Request;

class ProfileDashboardController extends Controller
{
    protected $service;
    public function __construct(ProfileService $service)
    {
        $this->service = $service;
    }
}
