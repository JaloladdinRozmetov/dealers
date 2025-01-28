<?php

namespace App\Http\Controllers;

use App\Models\Counter;
use App\Models\Dealer;
use App\Services\CounterConnectService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StatisticController extends Controller
{

    protected CounterConnectService $counterConnectService;
    public function __construct(CounterConnectService $counterConnectService)
    {
        $this->counterConnectService = $counterConnectService;
    }


    public function statistics()
    {
        $dealersWithCounters = Dealer::query()
            ->leftJoin('counters', 'dealers.id', '=', 'counters.dealer_id') // Join with counters table
            ->select(
                'dealers.id',
                'dealers.name',
                DB::raw('COUNT(counters.id) as counter_count'),
                DB::raw('GROUP_CONCAT(counters.serial_number) as counter_serial_numbers') // Aggregate serial numbers
            )
            ->groupBy('dealers.id', 'dealers.name') // Group by dealer ID and name
            ->get()
            ->map(function ($dealer) {
                $dealer->counter_serial_numbers = $dealer->counter_serial_numbers
                    ? explode(',', $dealer->counter_serial_numbers)
                    : []; // Convert serial numbers to an array
                return $dealer;
            })
            ->toArray();

        $dealersCounter = [];
        foreach ($dealersWithCounters as $counterStatus)
        {
            $data = $this->counterConnectService->fetchMeterStatus($counterStatus['counter_serial_numbers']);

            if (count($data['data']) != null)
            {
                $dealersCounter[$counterStatus['id']] = $data['data'];
            }
        }


        $data = [
            'dealersName' => array_column($dealersWithCounters, 'name'),
            'counterCounts' => array_column($dealersWithCounters, 'counter_count'),
            'activeCounterCounts' => array_map(function ($dealerId) use ($dealersCounter) {
                return isset($dealersCounter[$dealerId])
                    ? count(array_filter($dealersCounter[$dealerId], function ($counter) {
                        return isset($counter['status']) && $counter['status'] === 'ONLINE'; // Check for status condition
                    }))
                    : 0;
            }, array_column($dealersWithCounters, 'id')),
        ];

        return view('statistics',  [
            'dealersName' => $data['dealersName'],
            'counterCounts' => $data['counterCounts'],
            'activeCounterCounts' => $data['activeCounterCounts'],
        ]);
    }
}
