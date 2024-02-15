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
        $this->type_option = (isset($params['type_option'])) ? $params['type_option'] : 'all';
    }

    /**
     * @return Collection|\Illuminate\Support\Collection
     */
    public function collection(): Collection|\Illuminate\Support\Collection
    {
        $lomPosts =  DB::table('lom_posts')
            ->whereBetween('lom_posts.post_date',  [$this->from, $this->to])
            ->join('followers', function (JoinClause $join) {
                $join->on('lom_posts.lom_name', '=', 'followers.follower_name');
            })
            ->select('lom_posts.lom_name', 'lom_posts.post_link', 'lom_posts.post_type', 'followers.follower_job', 'lom_posts.post_prism');

        if ($this->type_option !== 'all') {
            $lomPosts->where('lom_posts.post_type', $this->type_option);
        }
        $lomPosts = $lomPosts->get();

        $arr = array();
        if (count($lomPosts) > 0) {
            foreach ($lomPosts as $lomPost) {
                $arr[] = [
                    'name' => $lomPost->lom_name,
                    'job' => $lomPost->follower_job,
                    'link' => $lomPost->post_link,
                    'type' => $lomPost->post_type,
                    'prism'  => $lomPost->post_prism
                ];
            }
            array_multisort($arr);
            $out[] = [
                'name' => $arr[0]['name'],
                'job' => $arr[0]['job'],
                'links' => $arr[0]['link'],
                'types' => $arr[0]['type'],
                'prisms' => $arr[0]['prism']
            ];
            $j = 0;
            for ($i=1; $i < count($arr); $i++) {
                if ($out[$j]['name'] == $arr[$i]['name']) {
                    $out[$j]['links'] .= Chr(10).$arr[$i]['link'];
                    $out[$j]['types'] .= Chr(10).$arr[$i]['type'];
                    $out[$j]['prisms'] .= Chr(10).$arr[$i]['prism'];
                } else {
                    $out[] = [
                        'name' => $arr[$i]['name'],
                        'job' => $arr[$i]['job'],
                        'links' => $arr[$i]['link'],
                        'types' => $arr[$i]['type'],
                        'prisms' => $arr[$i]['prism']
                    ];
                    $j++;
                }
            }
        }
        $collection = new Collection();
        foreach($out as $item) {
            $collection->push(
                (object)[
                    'name' => $item['name'],
                    'follower_job' => $item['job'],
                    'links' => $item['links'],
                    'type' => $item['types'],
                    'prism' => $item['prisms'],
                ]
            );
        }
        return $collection;
    }

    public function headings() :array
    {
        return [
            'Имя',
            'Должность',
            'Ссылки с '. $this->from. ' по ' .$this->to,
            'Тип поста',
            'Призма'
        ];
    }

}
