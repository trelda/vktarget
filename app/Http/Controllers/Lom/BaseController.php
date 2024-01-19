<?php

namespace App\Http\Controllers\Lom;

use App\Http\Controllers\Controller;
use App\Services\Lom\Service;

class BaseController extends Controller
{
    public $service;

    public function __construct(Service $service){

        $this->service = $service;

    }
}
