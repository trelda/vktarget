<?php

namespace App\Services\Member;
use App\Models\Member;

class Service {

    public function store($data) {
        Member::create($data);

    }

    public function update($member, $data) {
        $member->update($data);
    }
}