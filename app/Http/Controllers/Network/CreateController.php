<?php

namespace App\Http\Controllers\Network;

class CreateController extends BaseController
{
    public function __invoke() {
        return view('network.create');
    }
}