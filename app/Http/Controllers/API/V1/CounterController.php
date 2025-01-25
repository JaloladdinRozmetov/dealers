<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Models\Counter;
use App\Services\CounterService;
use Illuminate\Http\Request;

class CounterController extends Controller
{

    protected CounterService $counterService;

    public function __construct(CounterService $counterService)
    {
        $this->counterService = $counterService;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function caliber(Request $request)
    {
        $request->validate([
            'serialNumbers' => 'required|array',
            'serialNumbers.*' => 'integer|max:999999999999999|exists:counters,serial_number',
        ]);
        $counters = Counter::query()->select('serial_number','caliber')->whereIn('serial_number',$request->serialNumbers)->get();

        return response()->json([
            'message' => 'Success',
            'data' => $counters->toArray(),
        ]);
    }
    public function getInn(\App\Http\Requests\Counter $counterRequest)
    {
        $counters = $this->counterService->getInnCounter($counterRequest);

        return response()->json([
            'message' => 'Success',
            'data' => $counters->toArray(),
        ]);
    }

}
