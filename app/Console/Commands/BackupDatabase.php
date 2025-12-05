<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class BackupDatabase extends Command
{
    protected $signature = 'db:backup';
    protected $description = 'Backup the database';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $filename = 'backup-' . now()->format('Y-m-d_H-i-s') . '.sql';
        $path = storage_path("app/backups/{$filename}");

        // Fetch database credentials from .env
        $dbHost = env('DB_HOST', '127.0.0.1');
        $dbPort = env('DB_PORT', '3306');
        $dbName = env('DB_DATABASE', 'laravel');
        $dbUser = env('DB_USERNAME', 'root');
        $dbPassword = env('DB_PASSWORD', '');

        // Create backup folder if not exists
        if (!is_dir(storage_path('app/backups'))) {
            mkdir(storage_path('app/backups'), 0755, true);
        }

        // Prepare the mysqldump command
        $command = sprintf(
            'mysqldump --user=%s --password=%s --host=%s --port=%s %s > %s',
            escapeshellarg($dbUser),
            escapeshellarg($dbPassword),
            escapeshellarg($dbHost),
            escapeshellarg($dbPort),
            escapeshellarg($dbName),
            escapeshellarg($path)
        );

        // Execute the command
        exec($command, $output, $resultCode);

        if (file_exists($path) && $resultCode === 0) {

            // -------------------------------
            // 🔥 DELETE OLD BACKUPS HERE
            // -------------------------------
            $backupDir = storage_path('app/backups');
            $files = glob($backupDir . '/*.sql');

            // Sort descending (newest first)
            usort($files, function ($a, $b) {
                return filemtime($b) <=> filemtime($a);
            });

            // Remove all except first (latest)
            foreach (array_slice($files, 1) as $oldFile) {
                unlink($oldFile);
            }

            // -------------------------------

            $this->info("Backup created successfully: {$filename}");
        } else {
            $this->error("Backup failed! Check database credentials or permissions.");
        }
    }
}
