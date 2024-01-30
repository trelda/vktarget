<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Query\JoinClause;

use Illuminate\Database\Eloquent\Collection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class LomsPostExport implements FromCollection, WithHeadings
{
    public $from = '';
    public $to = '';
    public $type_option = '';

    public function __construct($params) {
        $this->from = $params['from'];
        $this->to = $params['to'];
        $this->type_option = $params['type_option'];
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        //TODO: итак понятно
        if ($this->type_option !== 'all') {
            $lomposts =  DB::table('lom_posts')
                ->whereBetween('lom_posts.post_date',  [$this->from, $this->to])
                ->where('lom_posts.post_type', $this->type_option)
                ->join('followers', function (JoinClause $join) {
                    $join->on('lom_posts.lom_name', '=', 'followers.follower_name');
                })
                ->select('lom_posts.lom_name', 'lom_posts.post_link', 'lom_posts.post_type', 'followers.follower_job')
                ->get();
            } else {
                $lomposts =  DB::table('lom_posts')
                ->whereBetween('lom_posts.post_date',  [$this->from, $this->to])
                ->join('followers', function (JoinClause $join) {
                    $join->on('lom_posts.lom_name', '=', 'followers.follower_name');
                })
                ->select('lom_posts.lom_name', 'lom_posts.post_link', 'lom_posts.post_type', 'followers.follower_job')
                ->get();
            }

            $arr = array();
            if (count($lomposts) > 0) {
                foreach ($lomposts as $lompost) {
                    $arr[] = ['name' => $lompost->lom_name, 'job' => $lompost->follower_job, 'link' => $lompost->post_link];
                }
                array_multisort($arr);
                $out[] = ['name' => $arr[0]['name'], 'job' => $arr[0]['job'], 'links' => $arr[0]['link']];
                $j = 0;
                for ($i=1; $i < count($arr); $i++) { 
                    if ($out[$j]['name'] == $arr[$i]['name']) {
                        $out[$j]['links'] .= Chr(10).Chr(13).$arr[$i]['link'];
                    } else {
                        $out[] = ['name' => $arr[$i]['name'], 'job' => $arr[$i]['job'], 'links' => $arr[$i]['link']];
                        $j++;
                    }
                }
            }

            $collection = new Collection();
            foreach($out as $item){
                $collection->push(
                    (object)[
                        'name' => $item['name'],
                        'follower_job' => $item['job'],
                        'links'=> $item['links'],
                ]);
            }
            return $collection;
    }
  
    public function headings() :array
    {
        return [
            'Имя',
            'Должность',
            'Ссылки с '. $this->from. ' по ' .$this->to,
        ];
    }

}
