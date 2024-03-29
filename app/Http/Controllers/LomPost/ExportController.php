<?php

namespace App\Http\Controllers\LomPost;

use App\Http\Requests\LomPost\ExportRequest;
use App\Exports\LomsPostExport;
use Maatwebsite\Excel\Facades\Excel;


class ExportController extends BaseController 
{
    public function __invoke(ExportRequest $request) {
        {
            $data = $request->validated();
            return Excel::download(new LomsPostExport($data), 'posts.xlsx');

        }
    }
}