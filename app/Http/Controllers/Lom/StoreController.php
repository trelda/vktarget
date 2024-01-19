<?php

namespace App\Http\Controllers\Lom;

use App\Http\Requests\Lom\StoreRequest;
use App\Models\User;
use App\Services\RabbitMQService\RabbitMQService;
//use Illuminate\Support\Facades\Auth;

class StoreController extends BaseController
{
    public function __invoke(StoreRequest $request) {

        $data = $request->validated();
        $followerId = $this->service->store($data);

        $rabbitService = new RabbitMQService();
        $params = [
            'method' => 'users.get',
            'userId' => Auth()->user()->id,
            'access_token' => User::find(Auth()->user()->id)->token,
            'user_ids' => str_replace("https://vk.com/", "", $data['url']),
            'followerId' => $followerId,
            'follower_job' => $data['follower_job']
        ];
        $rabbitService->publish(json_encode($params), 'vktarget', 'vktarget_newuser');
        return redirect()->route('lom.index');
    }
}