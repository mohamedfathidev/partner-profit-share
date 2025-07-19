<?php

use Carbon\Carbon;
use App\Models\Partner;
use Illuminate\Http\File;
use App\Models\ProfitShare;
use App\Models\Transaction;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\BackupController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ManagerController;
use App\Http\Controllers\PartnerController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\MonthProfitController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\MigrateToNewYearController;
use Tes\LaravelGoogleDriveStorage\GoogleDriveService;


Route::group(["middleware" => "auth", "prefix" => "dashboard"], function () {
    Route::get('/', function () {
        return view('dashboard');
    })->name('dashboard');

    // Return Json data
    Route::prefix('load')->group(function () {
        Route::get('/partners', [PartnerController::class, 'load'])->name('partners.load');
        Route::get('/transactions', [TransactionController::class, 'load'])->name('transactions.load');
        Route::get('/managers', [ManagerController::class, 'load'])->name('managers.load');
        Route::get('/month-profits', [MonthProfitController::class, 'load'])->name('month-profits.load');
        Route::get('/settings', [SettingController::class, 'load'])->name('settings.load');
    });

    // Partner resource
    Route::resource('partners', PartnerController::class);
    // Transaction resource
    Route::resource('transactions', TransactionController::class);
    // Manager resource
    Route::resource('managers', ManagerController::class);
    // MonthProfit resource
    Route::resource('month-profits', MonthProfitController::class);



    // Generate reports
    Route::get('/generate', [PartnerController::class, 'generatePdf']);


    
    // REPORTS
    Route::prefix('report')->name('report.')->group(function () {

        // General Monthly Reports
        Route::get('month', [ReportController::class, 'showGeneralMonthlyForm'])
            ->name('general.month');

        Route::post('month-generate', [ReportController::class, 'generateGeneralMonthlyReport'])
            ->name('general.month.generate');

        // General Annual Reports
        Route::get('annual', [ReportController::class, 'showGeneralAnnualForm'])
            ->name('general.annual');

        Route::post('annual-generate', [ReportController::class, 'generateGeneralAnnualReport'])
            ->name('general.annual.generate');

        // Spcific Partner Reports 
        Route::get('partner-monthly', [ReportController::class, 'showPartnerMonthlyForm'])->name('partner.monthly');
        
        Route::post('partner-month-generate', [ReportController::class, 'generatePartnerMonthlyReport'])
            ->name('partner.month.generate');
        
        
        Route::get('partner-annual', [ReportController::class, 'showPartnerAnnualForm'])->name('partner.annual');
        
        Route::post('partner-annual-generate', [ReportController::class, 'generatePartnerAnnualReport'])
            ->name('partner.annual.generate');
        
        Route::get('/partners-history', [ReportController::class, 'showPartnersHistory'])
            ->name('partners.history');
    });

    // Backup Sql DB to Drive 
    Route::get('/backup-to-drive', BackupController::class)->name('backup.to.drive');


    // Settings 
    Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
    Route::get('/settings/{setting}/edit', [SettingController::class, 'edit'])->name('settings.edit');
    Route::put('/settings/{setting}', [SettingController::class, 'update'])->name('settings.update');


    // Migrations

    Route::get('/migrate', [MigrateToNewYearController::class, 'showMigration'])->name('show.migration');
    Route::post('/migrate', [MigrateToNewYearController::class, 'migrate'])->name('migrate');

});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});




require __DIR__ . '/auth.php';

// Route::get('/test', function () {
//     $roundStartDate = Carbon::createFromDate(now()->subYear()->year, (int)setting("endRound"), 1)->startOfDay(); // 1-9-2024
//     $roundEndDate = Carbon::createFromDate(now()->year, 7, 1)->subDay()->endOfDay(); // 31-8-2025

//     $startOfMonth = $roundEndDate->copy()->startOfMonth();
//     $endOfMonth = $roundEndDate->copy()->endOfMonth();
//     $profitShares = ProfitShare::whereBetween('date', [$startOfMonth, $endOfMonth])->get();

//     dd($profitShares, $roundEndDate);
    
// });
