<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

use Illuminate\Support\Facades\DB;

class LomsExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $followers =  DB::table('followers')
            ->where('followers.user_id', '=', Auth()->user()->id)
            ->select('followers.url', 'followers.follower_name', 'followers.friends', 'followers.followers')
            ->get();
        return $followers;
    }
  
    public function headings() :array
    {
        return [
            'URL',
            'Имя',
            'Друзья',
            'Подписчики',
        ];
    }

}
