<?php

namespace App\Imports;

use App\Models\Phone;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class PhonesImport implements ToCollection, WithStartRow, WithMultipleSheets
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $row)
        {
            if ($row[0]) {
                Phone::firstOrCreate([
                    'value_unformatted' => Phone::Unformatted($row[0]),
                ],[
                    'value' => $row[0],
                    'value_unformatted' => Phone::Unformatted($row[0]),
                ]);
            }
        }
    }

    public function startRow(): int
    {
        return 2;
    }

    public function sheets(): array
    {
        return [
            0 => $this
        ];
    }
}
