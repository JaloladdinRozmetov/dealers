<?php

namespace App\Jobs;

use App\Models\Counter;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ImportPhoneJob implements ShouldQueue
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
                $phone_number =(int) trim( $data[1]);
                $iccid =(int) trim($data[2]);

                try {
                    Counter::query()->where('iccid',$iccid)->update([
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
