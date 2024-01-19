<?php

namespace App\Services\VKService;

use App\Models\Lom;
use App\Models\Member;
use App\Models\Network;

use App\Models\Post;
use App\Models\User;

CONST VERSION = '5.154';

class VKService
{

    public function checkUserToken($token) {
        //TODO: validate vk token
        $return = false;
        $url = "https://api.vk.com/method//users.get?access_token=" . $token . "&v=" . VERSION;
        $response = $this->curl($url);
        if (isset($response->error)) {
            return false;
        }
        else {
            $userId = $response->response[0]->id;
            $return = is_numeric($userId) ? true : false;
        }
        return $return;
    }

    public function vkGetGroup($param) {
        $paramArray = json_decode($param);

        $method = $paramArray->method;
        $groupId = $paramArray->groupId;
        
        unset($paramArray->method);
        unset($paramArray->groupId);
        unset($paramArray->userId);

        $url = "https://api.vk.com/method/" . $method . "?" . http_build_query($paramArray) . "&v=" . VERSION;
        $response = $this->curl($url);

        $network = Network::find($groupId);
        $data = [
            'id' => $groupId,
            'group_id' => $response->response->groups[0]->id,
            'group_name' => $response->response->groups[0]->name,
        ];
        $network->update($data);
    }

    public function vkGetUserId($param) {
        $paramArray = json_decode($param);

        $follower = Lom::find($paramArray->followerId);
        unset($paramArray->followerId);

        $method = $paramArray->method;
        unset($paramArray->method);
        unset($paramArray->userId);

        $url = "https://api.vk.com/method/" . $method . "?" . http_build_query($paramArray) . "&fields=followers_count&v=" . VERSION;
        $response = $this->curl($url);
        $data = [
            'follower_id' => $response->response[0]->id,
            'follower_name' => $response->response[0]->first_name . ' ' . $response->response[0]->last_name
        ];
        $data['followers'] = isset($response->response[0]->followers_count) ? $response->response[0]->followers_count : 0;
        $follower->update($data);

    }

    public function getGroupMembers($param) 
    {
        $paramArray = json_decode($param);
        $method = $paramArray->method;
        $method = 'groups.getMembers';
        $groupId = $paramArray->groupId;

        unset($paramArray->groupId);
        unset($paramArray->method);

        $url="https://api.vk.com/method/".$method."?".http_build_query($paramArray)."&v=".VERSION;
        $response = $this->curl($url);

        $data = [
            'members' => $response->response->count,
            'date' => date("Y-m-d H:i:s")
        ];
        $this->updateMembers($data);
    }

    public function updateMembers($data) {
        $dataArray = json_decode($data);
        foreach ($dataArray as $group) {
            var_dump($group);
            $group->date = date("Y:m:d H:i:s");
            if ($group->group_id) {
                Member::create([
                    "group_id" => $group->group_id,
                    "members" => $group->members,
                    "date" => $group->date
                ]);
            }
        }
    }

    public function updateFriends($data) {
        $dataArray = json_decode($data);
        foreach ($dataArray as $follower) {
            //TODO: фарш убрать
            if (isset($follower->followers)) {
                $lom = Lom::where('follower_id', '=', $follower->follower_id);
                $lom->update(["followers" => $follower->followers]);
            } else {
                $lom = Lom::find($follower->follower_id);
                $lom->update(["friends" => $follower->friends]);
            }
        }
    }

    public function curl($url) 
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

    public function getGroupPosts($net) {
        //TODO: сделать нормальный объект из поста, не вот эта мешанина для получения текста
        $token = User::find($net->user_id)->token;
        $groupId = $net->group_id;
        $paramArray = [
            'owner_id' => '-'.$groupId,
            'access_token' => $token
        ];

        $url="https://api.vk.com/method/wall.get?".http_build_query($paramArray)."&v=".VERSION;
        $response = $this->curl($url);

        if ($net->max_post !== $response->response->count) {
            $postDifference = $response->response->count - $net->max_post;
            echo $net->group_name . PHP_EOL;
            echo 'Not equal. Diff: ' . $postDifference . PHP_EOL;
            $net->update(['max_post' => $response->response->count]);
            foreach ($response->response->items as $item) {
                $repost = (isset($item->copy_history)) ? true : false;
                $description = '';
                if ($repost) {
                    if (isset($item->copy_history[0]->attachments[0]->type)) {
                        $attachType = $item->copy_history[0]->attachments[0]->type;
                        $description = (isset($item->copy_history[0]->attachments[0]->$attachType->description)) ? $item->copy_history[0]->attachments[0]->$attachType->description : '';
                    } else {
                        $description = $item->copy_history[0]->text;
                    }
                }
                //TODO: в реквест
                $itemTex = ($item->text != '') ? $item->text : $item->copy_history[0]->text;
                $postData = [
                    'ads' => $item->donut->is_donut,
                    'group_id' => $item->owner_id*(-1),
                    'post_id' => $item->id,
                    'caption' => $description,
                    'date' => date("Y-m-d H:i:s", $item->date),
                    'text' => $itemTex,
                    'views' => isset($item->views) ? $item->views->count : 0,
                    'likes' => isset($item->likes) ? $item->likes->count : 0,
                    'reposts' => isset($item->reposts) ? $item->reposts->count : 0,
                    'is_repost' => $repost,
                ];
                Post::create($postData);
            }
        } else {
            echo 'Equal: ' . $net->group_name . PHP_EOL;
        }
    }
};