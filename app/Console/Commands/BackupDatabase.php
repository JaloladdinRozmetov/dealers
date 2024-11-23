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

        // Fetch database credentials from .env via config
        $dbHost = env('DB_HOST', '127.0.0.1');
        $dbPort = env('DB_PORT', '3306');
        $dbName = env('DB_DATABASE', 'laravel');
        $dbUser = env('DB_USERNAME', 'root');
        $dbPassword = env('DB_PASSWORD', '');

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

        // Check if backup file was created successfully
        if (file_exists($path) && $resultCode === 0) {
            $this->info("Backup created successfully: {$filename}");
        } else {
            $this->error("Backup failed! Please check your database credentials or permissions.");
        }
    }
}
