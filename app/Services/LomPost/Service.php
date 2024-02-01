<?php

namespace App\Services\LomPost;
use App\Models\LomPost;

class Service {

    public function store($data) {
        $linksArray = array();
        $pattern = "/(?:(?:https?|ftp|file):\/\/|www\.|ftp\.)(?:\([-A-Z0-9+&@#\/%=~_|$?!:,.]*\)|[-A-Z0-9+&@#\/%=~_|$?!:,.])*(?:\([-A-Z0-9+&@#\/%=~_|$?!:,.]*\)|[A-Z0-9+&@#\/%=~_|$])/im";
        preg_match_all($pattern, $data['post_link'], $linksArray);
        foreach ($linksArray[0] as $item) {
            $lompost = LomPost::create([
                'lom_name' => $data['lom_name'],
                'post_link' => $item,
                'post_type' => $data['post_type'],
                'post_date' => $data['post_date']
            ]);
        }
        return $lompost->id;
    }

    Public function update($lompost, $data) {
        $lompost->update($data);
    }
}