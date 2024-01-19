<?php

namespace App\Services\LomPost;
use App\Models\LomPost;

class Service {

    public function store($data) {
        $lom = LomPost::create($data);
        return $lom->id;
    }

    Public function update($lom, $data) {
        $lom->update($data);
    }
}