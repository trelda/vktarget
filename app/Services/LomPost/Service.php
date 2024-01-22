<?php

namespace App\Services\LomPost;
use App\Models\LomPost;

class Service {

    public function store($data) {
        $lompost = LomPost::create($data);
        return $lompost->id;
    }

    Public function update($lompost, $data) {
        $lompost->update($data);
    }
}