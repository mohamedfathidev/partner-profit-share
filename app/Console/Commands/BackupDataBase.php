<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class BackupDataBase extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'database:backup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Backup the database';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $fileName = "backup". date('Y-m-d-H-i-s') . ".sql";
        $command = "mysqldump -u " . env('DB_USERNAME') . " " . env('DB_DATABASE') . " > " . storage_path("app/backups/" . $fileName);
        exec($command);
        $this->info("Database Backuped Successfully");
    }   
}
