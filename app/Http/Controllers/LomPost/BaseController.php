<?php

namespace App\Http\Controllers\LomPost;

use App\Http\Controllers\Controller;
use App\Services\LomPost\Service;

class BaseController extends Controller
{
    public $service;

    public function __construct(Service $service){

        $this->service = $service;

    }
}
