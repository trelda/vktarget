<?php

namespace App\Http\Controllers\LomPost;

use App\Http\Requests\LomPost\UpdateRequest;
use App\Models\LomPost;

class UpdateController extends BaseController
{
    public function __invoke(UpdateRequest $request, LomPost $lompost) {

        $data = $request->validated();
        $data['post_prism'] = isset($data['post_prism']) ? 'on' : null;
        $this->service->update($lompost, $data);
        return redirect()->route('lompost.index');
    }
}