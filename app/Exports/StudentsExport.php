<?php

namespace App\Exports;

use Illuminate\Database\Eloquent\Collection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;

class StudentsExport implements FromQuery
{
    use Exportable;

    public Collection $records;

    public function __construct(Collection $records)
    {
        $this->records = $records;
    }

    public function query()
    {
        dd($this->records);
    }
}
