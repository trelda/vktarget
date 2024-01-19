<?php

namespace App\Services\Network;
use App\Models\Network;
use Illuminate\Support\Facades\Auth;

class Service {

    public function store($data) {
        $data['user_id'] = Auth()->user()->id;
        $network = Network::create($data);
        return $network->id;
    }

    public function update($network, $data) {
        $network->update($data);
    }
}