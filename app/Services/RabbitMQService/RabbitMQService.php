<?php

namespace App\Services\RabbitMQService;

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
use Illuminate\Support\Facades\Auth;
use App\Services\VKService\VKService;

class RabbitMQService
{
    public function publish($message, $queue, $key)
    {
        $connection = new AMQPStreamConnection(env('RABBITMQ_HOST'), env('RABBITMQ_PORT'), env('RABBITMQ_USER'), env('RABBITMQ_PASSWORD'), env('RABBITMQ_VHOST'));
        $channel = $connection->channel();
        $channel->exchange_declare('vktarget_exchange', 'direct', false, true, false);
        $channel->queue_declare($queue, false, false, false, false);
        $channel->queue_bind($queue, 'vktarget_exchange', $key);
        $msg = new AMQPMessage($message);
        $channel->basic_publish($msg, 'vktarget_exchange', $key);
        $channel->close();
        $connection->close();
    }
    public function consume()
    {
        $connection = new AMQPStreamConnection(env('RABBITMQ_HOST'), env('RABBITMQ_PORT'), env('RABBITMQ_USER'), env('RABBITMQ_PASSWORD'), env('RABBITMQ_VHOST'));
        $channel = $connection->channel();

        $channel->queue_declare('vktarget', false, false, false, false);
        echo 'Waiting for new message on query' . PHP_EOL;
        $callback = function ($msg) {
            echo('query key: ' . $msg->delivery_info['routing_key'] . PHP_EOL);
            $vk = new VKService();
            switch($msg->delivery_info['routing_key']) {
                case 'vktarget_key':
                    echo 'in query' . PHP_EOL;
                    $vk->vkGetGroup($msg->body);
                    break;
                case 'vktarget_members':
                    echo 'get members' . PHP_EOL;
                    $vk->updateMembers($msg->body);
                    break;
                case 'vktarget_newuser':
                    echo 'get userId&name' . PHP_EOL;
                    $vk->vkGetUserId($msg->body);
                    break;
                case 'vktarget_followerupdate':
                    echo 'get friends' . PHP_EOL;
                    $vk->updateFriends($msg->body);
                    break;
                default:
                    echo $msg->body . PHP_EOL;
                    echo 'not in query' . PHP_EOL;
                    $vk->getGroupMembers($msg->body);
            }
        };
        $channel->basic_consume('vktarget', '', false, true, false, false, $callback);
        while ($channel->is_open()) {
            $channel->wait();
        }
        $channel->close();
        $connection->close();
    }
}