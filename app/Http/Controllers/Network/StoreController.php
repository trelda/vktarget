<?php

namespace App\Http\Controllers\Network;

use App\Http\Requests\Network\StoreRequest;
use App\Models\User;
use App\Services\RabbitMQService\RabbitMQService;
use Illuminate\Support\Facades\Auth;

class StoreController extends BaseController
{
    public function __invoke(StoreRequest $request) {

        $data = $request->validated();
        $groupId = $this->service->store($data);
        $rabbitService = new RabbitMQService();
        $params = [
            'method' => 'groups.getById',
            'userId' => Auth()->user()->id,
            'access_token' => User::find(Auth()->user()->id)->token,
            'group_ids' => str_replace("https://vk.com/", "", $data['url']),
            'groupId' => $groupId
        ];
        $rabbitService->publish(json_encode($params), 'vktarget', 'vktarget_key');
        return redirect()->route('network.index');
    }
}