<?php

namespace App\Http\Controllers\Lom;

class CreateController extends BaseController
{
    public function __invoke() {
        return view('lom.create');
    }
}