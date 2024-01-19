<?php

namespace App\Http\Controllers\LomPost;
use App\Models\Lom;

class CreateController extends BaseController
{
    
    public function __invoke() {

        $lomposts = Lom::all();

        return view('lompost.create', compact('lomposts'));
    }
}