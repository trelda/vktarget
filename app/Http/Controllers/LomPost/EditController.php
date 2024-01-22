<?php

namespace App\Http\Controllers\LomPost;

use App\Models\LomPost;
use Illuminate\Support\Facades\Auth;

class EditController extends BaseController
{
    public function __invoke(LomPost $lompost)
    {
        $lompost->post_prism = ($lompost->post_prism =='on') ? 'checked' : '';
        return view('lompost.edit', compact('lompost'));
    }
}