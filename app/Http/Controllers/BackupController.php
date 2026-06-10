<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BackupController extends Controller
{
    public function index()
    {
        return view('backup.index');
    }

    public function download()
    {
        $filename = 'backup_' . date('Ymd_His') . '.sql';

        $path = storage_path('app/backups');

        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        }

        $file = $path . '/' . $filename;

        $command =
            "mysqldump -u" . env('DB_USERNAME') .
            " -p'" . env('DB_PASSWORD') .
            "' " . env('DB_DATABASE') .
            " > " . $file;

        exec($command);

        activity_log(
            'BACKUP',
            'DATABASE',
            'Melakukan backup database'
        );

        return response()->download($file);
    }
}