<?php

namespace App\Models;

use App\Models\Traits\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Member extends Model
{
    use HasFactory, Filterable, SoftDeletes;

    protected $table = 'members';

    protected $fillable = [
        'group_id',
        'members',
        'date'
    ];
}
