<?php

namespace App\Http\Controllers\LomPost;

use App\Models\LomPost;

class DestroyController extends BaseController
{
    public function __invoke(LomPost $lom) {
            $lom->delete();
            return redirect()->route('lom.index');
    }
}