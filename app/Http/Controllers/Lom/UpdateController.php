<?php

namespace App\Http\Controllers\Lom;

use App\Http\Requests\Network\UpdateRequest;
use App\Models\Lom;

class UpdateController extends BaseController
{
    public function __invoke(UpdateRequest $request, Lom $lom) {
        $data = $request->validated();
        $this->service->update($lom, $data);
        return redirect()->route('lom.index');
    }
}