<?php

namespace App\Imports;

use Maatwebsite\Excel\Row;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ContactsImport implements OnEachRow, WithHeadingRow
{
    public $rows = [];

    public function onRow(Row $row)
    {
        $rowIndex = $row->getIndex();
        $row      = $row->toArray();

        $this->rows[] = [
            'row'   => $rowIndex,
            'name'  => $row['name'] ?? '',
            'phone' => $row['phone'] ?? '',
        ];
    }
}
