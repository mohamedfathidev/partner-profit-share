<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;


class BackupController extends Controller
{
    public function __invoke()
    {
        $fileName = "backup". date('Y-m-d-H-i-s') . ".sql";
        
        $command = "mysqldump -u ". env('DB_USERNAME'). " " . env('DB_DATABASE') . " > " . storage_path("app/backups/{$fileName}");

        exec($command);

        $filePath = storage_path("app/backups/{$fileName}");

        $fileContent = file_get_contents($filePath);

        Storage::disk('google')->put($fileName, $fileContent);

        return redirect()->route('transactions.index')->
            with('success', "تم رفع نسحة على ردايف بنجاح");      
    }
}
