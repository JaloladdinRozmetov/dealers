<?php

namespace App\Exports;

use App\Models\OfflineCounter;
use Maatwebsite\Excel\Concerns\FromCollection;

class OfflineCountersExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return OfflineCounter::where('name','GIDRO')->select('serial_number', 'hash')
            ->offset(20000) // Skip first 20,000 rows
            ->limit(25000)  // Get next 20,000 rows
            ->get()
            ->map(function ($counter) {
                return [
                    'serial_number' => $counter->serial_number,
                    'link' => 'https://dc.idealmeter.uz/counters/' . $counter->hash,
                ];
            });
    }

    public function headings(): array
    {
        return ['serial_number', 'link'];
    }
}
