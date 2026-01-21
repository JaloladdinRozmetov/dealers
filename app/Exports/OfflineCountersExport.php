<?php

namespace App\Exports;

use App\Models\OfflineCounter;
use Maatwebsite\Excel\Concerns\FromCollection;

class OfflineCountersExport implements FromCollection
{

    public function __construct(
        private ?int $from,
        private ?int $to,
        private ?string $name,
        private ?string $caliber
    ) {}


    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return OfflineCounter::query()
            ->when($this->from, fn ($q) =>
            $q->where('serial_number', '>=', $this->from)
            )
            ->when($this->to, fn ($q) =>
            $q->where('serial_number', '<=', $this->to)
            )
            ->when($this->name, fn ($q) =>
            $q->where('name', $this->name)
            )
            ->when($this->caliber, fn ($q) =>
            $q->where('caliber', $this->caliber)
            )
            ->select('serial_number', 'hash')
            ->get()
            ->map(fn ($counter) => [
                'serial_number' => $counter->serial_number,
                'link' => "https://dc.idealmeter.uz/counters/{$counter->hash}",
            ]);
    }

    public function headings(): array
    {
        return ['serial_number', 'link'];
    }
}
