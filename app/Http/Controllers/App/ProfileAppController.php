<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use App\Service\ProfileService;

class ProfileAppController extends Controller
{
    protected $service;
    public function __construct(ProfileService $service)
    {
        $this->service = $service;
    }
}
