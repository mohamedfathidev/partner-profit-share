<?php

namespace App\Http\Controllers;

use App\Models\MonthProfit;
use App\Services\BehindMigration;
use App\Services\MigrationService;
use Carbon\Carbon;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

class MigrateToNewYearController extends Controller
{
    public function showMigration(): View
    {
        return view('migration');
    }


    public function migrate(Request $request, MigrationService $migrationService): RedirectResponse
    {
        // أخر شهر 8 
        $roundEndDate = Carbon::createFromDate(now()->year, (int)setting("endRound"),1)->subDay()->endOfDay();
        $monthProfitOfendRound = MonthProfit::where('year', $roundEndDate->year)->where('month', $roundEndDate->month)->exists();

        // now => 7 , end => 8 || 7 > 8
        if (now()->lessThanOrEqualTo($roundEndDate) && !$monthProfitOfendRound)
        {
            return redirect()->back()->with('error', 'لا يمكن ترحيل إلا في نهاية الدورة المالية أو أن شهر الترحيل لم يوزع أرباحه');
        }


       $migration = $migrationService->migrateAndUpdate();

       if ($migration == false)
       {
            return redirect()->route('show.migration')->with('error', "تم ترحيل هذة السنة المالية من قبل");
       }
        
        return redirect()->route('show.migration')->with('success', 'تم الترحيل بنجاح');


    }

    


}
