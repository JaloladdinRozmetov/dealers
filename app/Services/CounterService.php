<?php

namespace App\Services;

use App\Models\Counter;

class CounterService
{


    public function getInnCounter($request)
    {
        $counters = Counter::query()
            ->select('serial_number', 'customer_id','caliber')
            ->with(['customer' => function ($query) {
                $query->select('id', 'organization_INN','personal_account_number'); // Select only the fields you need from the customer relation
            }])
            ->whereIn('serial_number', $request->serialNumbers)
            ->get()
            ->map(function ($counter) {
                return [
                    'serial_number' => $counter->serial_number,
                    'caliber' => $counter->caliber,
                    'inn' => $counter->customer->organization_INN ?? null,
                    'personalAccount' => $counter->customer->personal_account_number ?? null,
                ];
            });

        return $counters;
    }
}
