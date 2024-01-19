<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\Filterable;
use Illuminate\Database\Eloquent\SoftDeletes;
class LomPost extends Model
{
    use HasFactory, Filterable, SoftDeletes;

    protected $table = 'lom_posts';
    /*
    protected $fillable = [
        'id',
        'lom_name',
        'post_link',
        'post_type',
        'post_date'
    ];
    */
    protected $guarded = [];
}
