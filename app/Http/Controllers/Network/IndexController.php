<?php

namespace App\Http\Controllers\Network;


use App\Http\Filters\NetworkFilter;
use App\Models\Network;
use App\Http\Requests\Network\IndexRequest;

class IndexController extends BaseController
{
    //
    public function __invoke(IndexRequest $request)
    {
        $data = $request->validated();

        $filter = app()->make(NetworkFilter::class, ['queryParams' => array_filter($data)]);

        $networks = Network::filter($filter)->paginate(10);
        
        return view('network.index', compact('networks'));
    }
}
