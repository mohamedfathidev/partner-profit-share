<?php

use Carbon\Carbon;
use App\Models\Partner;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ManagerController;
use App\Http\Controllers\PartnerController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MonthProfitController;
use App\Http\Controllers\TransactionController;

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
    // Month reports & Pdfs
    Route::get('report/month', [ReportController::class, 'showGeneralMonthlyForm'])->name('report.general.month');
    Route::post('report/month/generate', [ReportController::class, 'generateGeneralMonthlyReport'])->name('report.general.month.generate');

    // Annual reports & Pdfs
    Route::get('report/annual', [ReportController::class, 'showGeneralAnnualForm'])->name('report.general.annual');
    Route::post('/report/annual/generate', [ReportController::class, 'generateGeneralAnnualReport'])->name('report.general.annual.generate');


    Route::get('/print-monthly-report', [ReportController::class, 'generateMonthlyPdf'])->name('month-report-print');
    Route::get('/pdf-generate', [ReportController::class, 'generatePDF'])->name('pdf-test');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});




require __DIR__ . '/auth.php';
