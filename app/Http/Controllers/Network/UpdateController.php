<?php

namespace App\Http\Controllers\Network;

use App\Http\Requests\Network\UpdateRequest;
use App\Models\Network;

class UpdateController extends BaseController
{
    public function __invoke(UpdateRequest $request, Network $network) {
        $data = $request->validated();
        $this->service->update($network, $data);
        return redirect()->route('network.index');
    }
}