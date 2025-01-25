<?php

namespace App\Services;

use App\Models\Counter;

class CounterService
{


    public function getInnCounter($request)
    {
        $counters = Counter::query()
            ->select('serial_number', 'customer_id')
            ->with(['customer' => function ($query) {
                $query->select('id', 'organization_INN'); // Select only the fields you need from the customer relation
            }])
            ->whereIn('serial_number', $request->serialNumbers)
            ->get()
            ->map(function ($counter) {
                return [
                    'serial_number' => $counter->serial_number,
                    'inn' => $counter->customer->organization_INN ?? null,
                ];
            });

        return $counters;
    }
}
