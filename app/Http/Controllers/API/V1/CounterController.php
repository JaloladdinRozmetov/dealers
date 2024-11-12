<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Models\Counter;
use Illuminate\Http\Request;

class CounterController extends Controller
{


    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function caliber(Request $request)
    {
        $request->validate([
            'serialNumber' => 'required|integer|max:999999999999999|exists:counters,serial_number',
        ]);
        $counter = Counter::query()->select('caliber')->where('serial_number',$request->serialNumber)->firstOrFail();

        return response()->json([
            'message' => 'Success',
            'Caliber' => $counter->caliber,
        ]);
    }

}
