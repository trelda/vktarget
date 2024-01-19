<?php

namespace App\Http\Controllers\LomPost;


use App\Http\Filters\LomPostFilter;
use App\Models\LomPost;
use App\Http\Requests\LomPost\IndexRequest;

class IndexController extends BaseController
{
    //
    public function __invoke(IndexRequest $request)
    {
        $data = $request->validated();

        $filter = app()->make(LomPostFilter::class, ['queryParams' => array_filter($data)]);

        $lomposts = LomPost::filter($filter)->paginate(10);


        return view('lompost.index', compact('lomposts'));
    }
}
