<?php

namespace App\Services\Post;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;

class Service {

    public function store($data) {
        //$data['user_id'] = Auth()->user()->id;
        $post = Post::create($data);
        return $post->id;
    }

    public function update($post, $data) {
        $post->update($data);
    }
}