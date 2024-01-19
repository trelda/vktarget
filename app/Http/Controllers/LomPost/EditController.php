<?php

namespace App\Http\Controllers\LomPost;

use App\Models\LomPost;
use Illuminate\Support\Facades\Auth;

class EditController extends BaseController
{
    public function __invoke(LomPost $lom)
    {
        return view('lom.edit', compact('lom'));
    }
}