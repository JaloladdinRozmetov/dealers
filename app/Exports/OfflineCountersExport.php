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
        return OfflineCounter::select('serial_number', 'hash')
            ->get()
            ->map(function ($counter) {
                return [
                    'serial_number' => $counter->serial_number,
                    'link' => 'http://localhost:8001/offline-counters/' . $counter->hash,
                ];
            });
    }

    public function headings(): array
    {
        return ['serial_number', 'link'];
    }
}
