<?php

namespace App\Jobs;

use App\Models\Counter;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ImportJob implements ShouldQueue
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

        // Check if the file exists
        if (!file_exists($file_path)) {
            dd("File does not exist: {$file_path}"); // Debugging line
        }

        // Check if the file is readable
        if (!is_readable($file_path)) {
            dd("File is not readable: {$file_path}"); // Debugging line
        }

        if (($handle = fopen($file_path, 'r')) !== false) {
            while (($data = fgetcsv($handle, 10000, ',')) !== false) {
                $serial_number =(int) trim( $data[0]);
                $caliber = (string) trim($data[1]);
                $imei = (int) trim($data[2]);
                $iccid =(int) trim($data[3]);

                try {
                    // Insert or update the Counter model
                    Counter::query()->updateOrCreate(
                        ['serial_number' => $serial_number],
                        [
                            'caliber' => $caliber,
                            'imei' => $imei,
                            'iccid' => $iccid,
                        ]
                    );
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
