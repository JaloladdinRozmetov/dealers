<?php

namespace App\Http\Controllers;

use App\Exports\OfflineCountersExport;
use App\Http\Requests\FilterOfflineCounterRequest;
use App\Models\OfflineCounter;
use App\Services\OfflineCounterService;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class OfflineCounterController extends Controller
{
    protected OfflineCounterService $service;

    public function __construct(OfflineCounterService $service)
    {
        $this->service = $service;
    }

    /**
     * @param FilterOfflineCounterRequest $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
     */
    public function index(FilterOfflineCounterRequest $request)
    {
        $serialNumber = $request->input('serial_number');
        $counters = $this->service->getFilteredCounters($serialNumber);

        return view('offline_counters.index', compact('counters', 'serialNumber'));
    }

    public function export(Request $request)
    {
        return Excel::download(
            new OfflineCountersExport(
                $request->input('from'),
                $request->input('to'),
                $request->input('name'),
                $request->input('caliber')
            ),
            'offline_counters.xlsx'
        );
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
     */
    public function show($hash)
    {
        $counter = $this->service->getByHash($hash);

        if (!$counter) {
            abort(404, 'Offline Counter not found.');
        }

        return view('counters.offline_counters', compact('counter'));
    }
}
