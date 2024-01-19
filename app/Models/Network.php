<?php

namespace App\Models;

use App\Models\Traits\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Network extends Model
{
    use HasFactory, SoftDeletes, Filterable;
    protected $table = 'networks';

    protected $fillable = [
        'url',
        'type',
        'user_id',
        'group_id',
        'group_name',
        'max_post'
    ];

    public function delta() {
        $members =  Member::where('group_id', $this->group_id)
            ->orderByDesc('id')
            ->take(1)
            ->get('members');
        return (isset($members[0]->members)) ? $members[0]->members : 0 ;
    }
}
