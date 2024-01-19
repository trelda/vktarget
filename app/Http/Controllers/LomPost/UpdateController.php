<?php

namespace App\Http\Controllers\LomPost;

use App\Http\Requests\Network\UpdateRequest;
use App\Models\LomPost;

class UpdateController extends BaseController
{
    public function __invoke(UpdateRequest $request, LomPost $lom) {
        $data = $request->validated();
        $this->service->update($lom, $data);
        return redirect()->route('lompost.index');
    }
}