<?php

namespace App\Exports;

use App\Models\Network;
use App\Models\Member;
use Illuminate\Database\Query\JoinClause;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

use Illuminate\Support\Facades\DB;

class NetworksExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {

$networks = Network::where('networks.user_id', '=', Auth()->user()->id)
        ->join('members', function (JoinClause $join) {
            $join->on('members.id', '=', DB::raw('(SELECT MAX(`members`.`id`) FROM members WHERE `members`.`group_id` = `networks`.`group_id`)'));
          })
        ->select('networks.url', 'networks.group_name', 'members.members')
        ->get();

        return $networks;
    }
  
    public function headings() :array
    {
        return [
            'URL',
            'Название',
            'Подписчики',
        ];
    }

}
