<?php

namespace App\Http\Controllers\Network;

use App\Models\Network;

class DestroyController extends BaseController
{
    public function __invoke(Network $network) {
            $network->delete();
            return redirect()->route('network.index');
    }
}