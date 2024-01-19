<?php

namespace App\Http\Controllers\Lom;

use App\Models\Lom;
use Illuminate\Support\Facades\Auth;

class EditController extends BaseController
{
    public function __invoke(Lom $lom)
    {
        return view('lom.edit', compact('lom'));
    }
}