<?php

namespace App\Http\Controllers\Lom;


use App\Http\Filters\LomFilter;
use App\Models\Lom;
use App\Http\Requests\Lom\IndexRequest;

class IndexController extends BaseController
{
    //
    public function __invoke(IndexRequest $request)
    {
        $data = $request->validated();

        $filter = app()->make(LomFilter::class, ['queryParams' => array_filter($data)]);

        $loms = Lom::filter($filter)->paginate(10);
        
        return view('lom.index', compact('loms'));
    }
}
