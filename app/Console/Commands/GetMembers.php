<?php

namespace App\Console\Commands;

use App\Models\Network;
use App\Models\User;
use App\Services\RabbitMQService\RabbitMQService;
use Illuminate\Console\Command;

class GetMembers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:get-members';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Parse group memnbers';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $time_start = microtime(true);
        $networks = Network::all();
        $code = "var out = '';var response = [];";        
        $i = 0;
        foreach ($networks as $net) {
            $token = User::find($net->user_id)->token;
            $code .= 'out = API.groups.getMembers({"group_id":"'.$net->group_id.'", "access_token":"'.$token.'", "v":"5.150"});
            response.push({"itemId":"'.$net->id.'", "item":"'.$net->group_id.'", "data":out});';
            $i++;
            if ($i === 20) {
                $code .= 'return response;';
                $this->parseResponse($code, $token);
                $code = "var out = '';var response = [];";
                $i = 0;
            }
        }
        $code .= 'return response;';
        $this->parseResponse($code, $token);
        $time_end = microtime(true);
        $execution_time = ($time_end - $time_start)/60;
        echo 'work time: ' . $execution_time . PHP_EOL;
    }


    public function GetVKMembers($url, $params) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_REFERER, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }

    public function parseResponse($code, $token) {
        $response = [];
        $execute = json_decode($this->GetVKMembers('https://api.vk.com/method/execute', array(
            'code' => $code,
            'access_token' => $token,
            'v' => '5.150'
        )), true);
        foreach ($execute['response'] as $one) {
            if ($one['data']) {
                $response[] = [
                    "group_id" => $one['item'],
                    "members" => $one['data']['count']
                ];
            } else {
                $response[] = [
                    "group_id" => $one['item'],
                    "members" => 0
                ];
            }
        }
        $rabbitService = new RabbitMQService();
        $rabbitService->publish(json_encode($response), 'vktarget', 'vktarget_members');
    }
}
