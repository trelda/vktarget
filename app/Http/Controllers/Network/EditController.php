<?php

namespace App\Http\Controllers\Network;

use App\Models\Network;
use Illuminate\Support\Facades\Auth;

class EditController extends BaseController
{
    public function __invoke(Network $network)
    {
        return view('network.edit', compact('network'));
    }
}