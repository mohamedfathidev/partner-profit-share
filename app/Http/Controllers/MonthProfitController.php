<?php

namespace App\Http\Controllers;

use App\Models\Manager;
use App\Models\MonthProfit;
use App\Models\Partner;
use App\Services\CheckMonthClosedService;
use App\Services\ProfitDistributionWithTransactionsService;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MonthProfitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        return view('month-profits.index');
    }

    public function load(Request $request): JsonResponse
    {
        if (!$request->ajax()) {
            abort(403, 'Unauthorized access, Contact Admin');
        }

        $records = MonthProfit::select('id', 'total_profit', 'unused_goods', 'status', 'created_at', 'year', 'month');

        if ($request->filled('from_date') && $request->filled('to_date')) {
           $records->whereBetween('created_at', [$request->from_date, $request->to_date]);
        }

        return datatables()
            ->of($records)
            ->addColumn('date', function ($row) {
                return Carbon::createFromDate($row->year, $row->month, 25)->locale('ar')->translatedFormat('F Y');
            })
            ->addColumn('actions', function ($row) {
                $buttons = " ";

                if ($row->status == 'open') {
                    $buttons .= "<a href='/dashboard/month-profits/$row->id/edit' class='btn btn-sm btn-warning' style='margin-left:5px;'>تعديل</a>";

                }
                $buttons .= "<a href='javascript:void(0);' data-url='/dashboard/month-profits/$row->id' class='delete-record btn btn-sm btn-danger'>حذف</a>";

                return $buttons;
            })
            ->rawColumns(['actions'])
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('month-profits.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, ProfitDistributionWithTransactionsService $profitDistribution, CheckMonthClosedService $checkMonthIsClosed)
    {
        $request->validate([
            "total_profit" => "required|numeric",
            "unused_goods" => "required|numeric",
        ],[
            "total_profit.numeric" => "يجب إدخال أرقام",
            "unused_goods.numeric" => "يجب إدخال أرقام"
        ]);

        $existedMonthProfit = $checkMonthIsClosed->monthIsClosed(Carbon::parse($request->get('date')));

        if($existedMonthProfit) {
            return redirect()->route('month-profits.create')
                ->with('error', ' تم إدخال ربح شهري لهذا الشهر لا يمكن إدخال ربح');
        }

        $month = Carbon::parse($request->get('date'))->month;
        $year = Carbon::parse($request->get('date'))->year;
        $day = Carbon::parse($request->get('date'))->day;
        $lastDayOfMonth = Carbon::parse($request->get('date'))->endOfMonth()->day;

        // Just insert Date between 25 -> end of month only, work with days only for entering  past months
        if ($day < 25 || $day > $lastDayOfMonth) {
            return redirect()->route('month-profits.create')
                ->with('error', 'يمكنك إدخال ربح شهري فقط في الفترة من يوم 25 إلى نهاية الشهر.');
        }


        $monthProfit = MonthProfit::create([
            "month" => $month,
            "year" => $year,
            "total_profit" => $request->get('total_profit'),
            "unused_goods" => $request->get('unused_goods'),
        ]);

        $netProfit = $request->input('total_profit') - $request->input('unused_goods');

        // Distribute the monthly profit
        $profitDistribution->distributeMonthlyProfit($netProfit, $monthProfit->id, $month, $year);

        return redirect()->route('month-profits.index')
            ->with('success', 'تم توزيع بنجاح الرجاء التأكد!');

    }

    /**
     * Display the specified resource.
     */
    public function show(MonthProfit $monthProfit)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MonthProfit $monthProfit)
    {
        $details = $monthProfit;

        // Edit can happen only for the last month
        $latestMonth = MonthProfit::latest('created_at')->first()->id;
        $monthId = $monthProfit->id;

        if ($monthId !== $latestMonth)
        {
            return redirect()->route('month-profits.index')
                ->with('error', 'فقط يمكن تعديل أخر شهر تم توزيع أرباحه');
        }


        return view('month-profits.edit', compact('details'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, MonthProfit $monthProfit, ProfitDistributionWithTransactionsService $profitDistribution)
    {
        // delete profit shares for this month
        $monthProfit->profitShares()->delete();

        // Validte data from request form
        $request->validate([
            "total_profit" => "required|numeric",
            "unused_goods" => "required|numeric",
        ],[
            "total_profit.numeric" => "يجب إدخال أرقام",
            "unused_goods.numeric" => "يجب إدخال أرقام"
        ]);

        $month = Carbon::parse($request->get('date'))->month;
        $year = Carbon::parse($request->get('date'))->year;
        $day = Carbon::parse($request->get('date'))->day;
        $lastDayOfMonth = Carbon::parse($request->get('date'))->endOfMonth()->day;

        // Just insert Date between 25 -> end of month only, work with days only for entering  past months
        if ($day < 25 || $day > $lastDayOfMonth) {
            return redirect()->route('month-profits.edit', $monthProfit->id)
                ->with('error', 'يمكنك إدخال ربح شهري فقط في الفترة من يوم 25 إلى نهاية الشهر.');
        }

         $monthProfit->update([
            "month" => $month,
            "year" => $year,
            "total_profit" => $request->get('total_profit'),
            "unused_goods" => $request->get('unused_goods'),
        ]);

        $netProfit = $request->input('total_profit') - $request->input('unused_goods');

        // Distribute the monthly profit
        $profitDistribution->distributeMonthlyProfit($netProfit, $monthProfit->id, $month, $year);

        return redirect()->route('month-profits.index')
            ->with('success', 'تم تعديل الربح الشهر للشهر الأخير بنجاح الرجاء التأكد!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MonthProfit $monthProfit)
    {
        //
    }
}
