<?php

namespace App\Http\Controllers\Network;


use App\Exports\NetworksExport;
use Maatwebsite\Excel\Facades\Excel;


class ExportController extends BaseController 
{
    public function export() 
    {
        return Excel::download(new NetworksExport, 'users.xlsx');
    }
}
