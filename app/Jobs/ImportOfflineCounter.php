<?php

namespace App\Jobs;

use App\Models\Counter;
use App\Models\OfflineCounter;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Date;

class ImportOfflineCounter implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(protected string $filePath)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $file_path = storage_path('app/' . $this->filePath); // Use storage_path to access the stored file

        if (!file_exists($file_path)) {
            dd("File does not exist: {$file_path}"); // Debugging line
        }

        if (!is_readable($file_path)) {
            dd("File is not readable: {$file_path}"); // Debugging line
        }

        if (($handle = fopen($file_path, 'r')) !== false) {
            while (($data = fgetcsv($handle, 10000, ',')) !== false) {
                $serial_number = trim( $data[1]);
                $name = trim($data[2]);
                $caliber = trim($data[3]);
                $production_time = trim($data[4]);
                $producer_country = trim($data[5]);
                $supplier = trim($data[6]);
                $phone_number = trim($data[7]);

                try {
                    OfflineCounter::query()->updateOrCreate(['serial_number' => $serial_number],
                        [
                            'caliber' => $caliber,
                            'name' => $name,
                            'production_time' => $production_time.'-01-01',
                            'producer_country' => $producer_country,
                            'supplier' => $supplier,
                            'phone_number' => $phone_number,
                        ]);

                } catch (\Exception $e) {
                    dd($e->getMessage());
                }
            }
            fclose($handle);
        } else {
            dd("Cannot open file: {$file_path}");
        }
    }
}
