<?php

namespace App\Models;

use App\Models\Traits\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Lom extends Model
{
    use HasFactory, Filterable, SoftDeletes;

    protected $table = 'followers';

    protected $fillable = [
        'url',
        'type',
        'follower_id',
        'follower_name',
        'follower_job',
        'user_id',
        'friends',
        'followers'
    ];
}
