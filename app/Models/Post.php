<?php

namespace App\Models;

use App\Models\Traits\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use HasFactory, SoftDeletes, Filterable;
    protected $table = 'posts';

    protected $fillable = [
        'group_id',
        'post_id',
        'ads',
        'caption',
        'date',
        'text',
        'views',
        'likes',
        'reposts',
        'is_repost'
    ];

    public function networkName() {
        $network =  Network::where('group_id', $this->group_id)
            ->orderByDesc('id')
            ->take(1)
            ->get('group_name');
        return (isset($network[0]->group_name)) ? $network[0]->group_name : '' ;
    }
}
