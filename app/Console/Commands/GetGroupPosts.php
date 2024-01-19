<?php

namespace App\Console\Commands;

use App\Models\Network;
use Illuminate\Console\Command;
use App\Services\VKService\VKService;

class GetGroupPosts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:get-group-posts';

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
        $time_start = microtime(true);
        $networks = Network::all();
        $vk = new VKService();
        foreach ($networks as $net) {
            $vk->getGroupPosts($net);
        }
        $time_end = microtime(true);
        $execution_time = ($time_end - $time_start)/60;
        echo 'work time: ' . $execution_time . PHP_EOL;
    }
}
