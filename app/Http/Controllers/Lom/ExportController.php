<?php

namespace App\Http\Controllers\Lom;


use App\Exports\LomsExport;
use Maatwebsite\Excel\Facades\Excel;


class ExportController extends BaseController 
{
    public function export() 
    {
        return Excel::download(new LomsExport, 'users.xlsx');
    }
}
