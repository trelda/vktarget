<?php

namespace App\Http\Controllers\LomPost;

use App\Http\Requests\LomPost\StoreRequest;


class StoreController extends BaseController
{
    public function __invoke(StoreRequest $request) {

        $data = $request->validated();

        $this->service->store($data);

        return redirect()->route('lompost.index');
    }
}