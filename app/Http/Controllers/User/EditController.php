<?php

namespace App\Http\Controllers\User;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class EditController extends BaseController
{
    public function __invoke(User $user)
    {
        if (Auth()->user()->role  !== 'admin')
        {
            $user = User::find(Auth()->user()->id);
        }
        return view('user.edit', compact('user'));
    }
}