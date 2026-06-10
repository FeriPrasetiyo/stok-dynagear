<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class BackupDatabase extends Command
{
    protected $signature = 'backup:database';

    protected $description = 'Backup database otomatis';

    public function handle()
    {
        $backupPath = storage_path('app/backups');

        if (!file_exists($backupPath)) {
            mkdir($backupPath, 0777, true);
        }

        $filename = 'backup_' . date('Y-m-d_H-i-s') . '.sql';
        $file = $backupPath . '/' . $filename;

        $command = 'mysqldump -u' . env('DB_USERNAME') .
            ' -p' . env('DB_PASSWORD') .
            ' ' . env('DB_DATABASE') .
            ' > ' . $file;

        exec($command);

        $this->info('Backup berhasil dibuat: ' . $filename);

        return Command::SUCCESS;
    }
}