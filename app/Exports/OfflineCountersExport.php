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
        private ?string $production_time,
        private ?string $caliber
    ) {}


    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $serials = range($this->from, $this->to);

        $counters = collect($serials)->map(function ($serial) {
            return OfflineCounter::firstOrCreate(
                ['serial_number' => $serial],
                [
                    'name' => $this->name,
                    'caliber' => $this->caliber,
                    'phone_number' => '+998772820001',
                    'supplier' => '"IDEALMETER" MCHJ',
                    'producer_country' => 'Xitoy',
                    'production_time' => $this->production_time
                ]
            );
        });

        return $counters->map(fn ($counter) => [
            'serial_number' => $counter->serial_number,
            'link' => "https://dc.idealmeter.uz/counters/{$counter->hash}",
        ]);
    }

    public function headings(): array
    {
        return ['serial_number', 'link'];
    }
}
