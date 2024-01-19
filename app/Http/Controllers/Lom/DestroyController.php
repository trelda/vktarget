<?php

namespace App\Http\Controllers\Lom;

use App\Models\Lom;

class DestroyController extends BaseController
{
    public function __invoke(Lom $lom) {
            $lom->delete();
            return redirect()->route('lom.index');
    }
}