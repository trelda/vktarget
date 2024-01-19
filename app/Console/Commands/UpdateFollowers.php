<?php

namespace App\Console\Commands;

use App\Models\Lom;
use App\Models\User;
use App\Services\RabbitMQService\RabbitMQService;
use Illuminate\Console\Command;

CONST VERSION = '5.154';

class UpdateFollowers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:update-followers';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        echo 'parse friends'.PHP_EOL;
        $time_start = microtime(true);
        $loms = Lom::all();
        $code = "var out = '';var response = [];";        
        $i = 0;
        $lomsGroup = [];
        foreach ($loms as $lom) {
            $lomsGroup[] = [
                'id' => $lom->id,
                'user_ids' => $lom->follower_id,
            ];
            $token = User::find($lom->user_id)->token;

            $code .= 'out = API.friends.get({"user_id":"'.$lom->follower_id.'", "access_token":"'.$token.'", "v":"5.154"});
            response.push({"followerId":"'.$lom->id.'", "data":out});';
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
        $this->parseLomFollowers($lomsGroup, $token);
    }

    public function parseLomFollowers($loms, $token) {
        $i = 0;
        $code = "var out = '';var response = [];";;
        $users = '';
        foreach ($loms as $lom) {
            $users .= $lom['user_ids'] . ',';
            $i++;
            if ($i === 20) {
                $code .= 'out = API.users.get({"user_ids":"'.$users.'", "access_token":"'.$token.'", "v":"5.154", "fields":"followers_count"});
                response.push({"data":out});';
                $code .= 'return response;';
                $this->parseResponse($code, $token, true);
                $code = "var out = '';var response = [];";
                $i = 0;
                $users = '';
            }
        }
        $code .= 'out = API.users.get({"user_ids":"'.$users.'", "access_token":"'.$token.'", "v":"5.154", "fields":"followers_count"});
        response.push({"data":out});';
        $code .= 'return response;';
        $this->parseResponse($code, $token, true);
    }

    public function curl($url, $params) {
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
        $result = json_decode(curl_exec($ch), true);
        curl_close($ch);
        return $result;
    }
/*
    public function curl1($url) 
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10); 
        curl_setopt($ch, CURLOPT_POST, 1);	 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);				
        curl_setopt($ch, CURLOPT_URL, $url);
        $response = json_decode(curl_exec($ch));
        return $response;
    }
*/

    public function parseResponse($code, $token, $friends = false) {
        $response = [];
        $execute = $this->curl('https://api.vk.com/method/execute', array(
            'code' => $code,
            'access_token' => $token,
            'v' => '5.154'
        ));

        if ($friends) {
            foreach ($execute['response'][0]['data'] as $one) {
                $count = isset($one['followers_count']) ? $one['followers_count'] : 0;
                $response[] = [
                    "follower_id" => $one['id'],
                    "followers" => $count
                ];
            }
        } else {
            foreach ($execute['response'] as $one) {
                if ($one['data']) {
                    $response[] = [
                        "follower_id" => $one['followerId'],
                        "friends" => $one['data']['count']
                    ];
                }
            }
        }
        $rabbitService = new RabbitMQService();
        $rabbitService->publish(json_encode($response), 'vktarget', 'vktarget_followerupdate');
    }

}