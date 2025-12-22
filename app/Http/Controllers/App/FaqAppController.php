<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use App\Service\FaqService;

class FaqAppController extends Controller
{
    protected $service;
    public function __construct(FaqService $service)
    {
        $this->service = $service;
    }
}
