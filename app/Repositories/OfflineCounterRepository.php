<?php

namespace App\Repositories;

use App\Models\OfflineCounter;

class OfflineCounterRepository
{
    public function getAllWithFilter(?string $serialNumber, int $perPage = 10)
    {
        $query = OfflineCounter::query();

        if ($serialNumber) {
            $query->where('serial_number', 'like', '%' . $serialNumber . '%');
        }

        return $query->paginate($perPage);
    }

    public function findByHash(string $hash): ?OfflineCounter
    {
        return OfflineCounter::where('hash',$hash)->first();
    }
}
