<?php

namespace App\Http\Controllers\User;

use App\Http\Requests\User\UpdateRequest;
use App\Models\User;
use App\Services\VKService\VKService;

class UpdateController extends BaseController
{
    public function __invoke(UpdateRequest $request, User $user) {
        $data = $request->validated();
        $service = new VKService();
        $checkToken = $service->checkUserToken($data['token']);
        if ($checkToken) {
            $this->service->update($user, $data);
            return redirect()->route('user.index');
        } else {
            $user = User::find(Auth()->user()->id);
            return view('user.edit', compact('user'));
        }
    }
}