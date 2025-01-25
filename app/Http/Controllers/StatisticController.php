<?php

namespace App\Http\Controllers;

use App\Models\Counter;
use App\Models\Dealer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StatisticController extends Controller
{
    public function statistics()
    {


        $dealersWithCounters = Dealer::query()
            ->leftJoin('counters', 'dealers.id', '=', 'counters.dealer_id') // Join with counters table
            ->select('dealers.id', 'dealers.name', DB::raw('COUNT(counters.id) as counter_count')) // Select dealer details and count
            ->groupBy('dealers.id', 'dealers.name') // Group by dealer ID and name
            ->get()->toArray();

        $data = [
            'dealersName' => array_column($dealersWithCounters, 'name'),
            'counterCounts' => array_column($dealersWithCounters, 'counter_count'),
        ];

        return view('statistics',  [
            'dealersName' => $data['dealersName'],
            'counterCounts' => $data['counterCounts']
        ]);
    }
}
