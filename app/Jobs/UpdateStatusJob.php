<?php

namespace App\Jobs;

use Carbon\Carbon;
use App\Models\MonthProfit;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;

class UpdateStatusJob
{
    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        MonthProfit::where('status', '=', 'open')
//            ->where('created_at', '<=', Carbon::now()->subMinute())
            ->update(["status" => "closed"]);

        Log::info("the months statuses has been changed from open to closed");
    }
}
