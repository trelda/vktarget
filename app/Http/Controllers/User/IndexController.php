<?php

namespace App\Http\Controllers\User;


use App\Http\Filters\UserFilter;
use App\Models\User;
use App\Http\Requests\User\IndexRequest;

class IndexController extends BaseController
{
    //
    public function __invoke(IndexRequest $request)
    {
        $data = $request->validated();

        $filter = app()->make(UserFilter::class, ['queryParams' => array_filter($data)]);

        $users = User::filter($filter)->paginate(2);
        
        return view('user.index', compact('users'));
    }
}
