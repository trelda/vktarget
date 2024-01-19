<?php

namespace App\Services\Lom;
use App\Models\Lom;
use Illuminate\Support\Facades\Auth;

class Service {

    public function store($data) {
        $data['user_id'] = Auth()->user()->id;
        $lom = Lom::create($data);
        return $lom->id;
    }

    Public function update($lom, $data) {
        $lom->update($data);
    }
}