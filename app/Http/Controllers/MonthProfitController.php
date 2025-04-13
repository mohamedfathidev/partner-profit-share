<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Manager;
use App\Models\Partner;
use Illuminate\View\View;
use App\Models\MonthProfit;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use App\Services\CheckMonthClosedService;
use App\Services\ProfitDistributionWithTransactionsService;

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
        ], [
            "total_profit.numeric" => "يجب إدخال أرقام",
            "unused_goods.numeric" => "يجب إدخال أرقام"
        ]);

        // I didn't make MonthIsClosed private function but service because it used in antoher place out of this controller 
        $monthIsClosed  = $checkMonthIsClosed->monthIsClosed(Carbon::parse($request->get('date')));

        if ($monthIsClosed) {
            return redirect()->route('month-profits.create')
                ->with('error', ' تم إدخال ربح شهري لهذا الشهر لا يمكن إدخال ربح');
        }

        $date = $this->extractDateComponents($request->get('date'));

        // Just insert Date between 25 -> end of month only, work with days only for entering  past months
        $redirect = $this->validateDateWithinAllowedRange($request->get('date'));
        if ($redirect) return $redirect;
         

        $monthProfit = MonthProfit::create([
            "month" => $date['month'],
            "year" => $date['year'],
            "total_profit" => $request->get('total_profit'),
            "unused_goods" => $request->get('unused_goods'),
        ]);

        $netProfit = $request->input('total_profit') - $request->input('unused_goods');

        // Distribute the monthly profit
        $profitDistribution->distributeMonthlyProfit($netProfit, $monthProfit->id, $date['month'], $date['year']);

        return redirect()->route('month-profits.index')
            ->with('success', 'تم توزيع بنجاح الرجاء التأكد!');
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

        if ($monthId !== $latestMonth) {
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
        ], [
            "total_profit.numeric" => "يجب إدخال أرقام",
            "unused_goods.numeric" => "يجب إدخال أرقام"
        ]);

        $date = $this->extractDateComponents($request->get('date'));

        // Just insert Date between 25 -> end of month only, work with days only for entering  past months
        $redirect = $this->validateDateWithinAllowedRange($request->get('date'));
        if ($redirect) return $redirect;



        $monthProfit->update([
             "month" => $date['month'],
            "year" => $date['year'],
            "total_profit" => $request->get('total_profit'),
            "unused_goods" => $request->get('unused_goods'),
        ]);

        $netProfit = $request->input('total_profit') - $request->input('unused_goods');

        // Distribute the monthly profit
        $profitDistribution->distributeMonthlyProfit($netProfit, $monthProfit->id, $date['month'], $date['year']);

        return redirect()->route('month-profits.index')
            ->with('success', 'تم تعديل الربح الشهر للشهر الأخير بنجاح الرجاء التأكد!');
    }

    /**
     * Remove the specified resource from storage.
     * Deleting MonthProfit is disabled for data integrity reasons
     */
    public function destroy(MonthProfit $monthProfit)
    {
        //
    }


    private function validateDateWithinAllowedRange(string $date): ?RedirectResponse
    {
        $carbonDate = Carbon::parse($date);
        $day = $carbonDate->day;
        $lastDayOfMonth = $carbonDate->endOfMonth()->day;

        if ($day < 25 || $day > $lastDayOfMonth) {
            return redirect()->back()->with('error', 'يمكنك إدخال ربح شهري فقط في الفترة من يوم 25 إلى نهاية الشهر.');
        }

        return null;
    }


    private function extractDateComponents(string $date): array
    {
        $carbonDate = Carbon::parse($date);
        return [
            'month' => $carbonDate->month,
            'year' => $carbonDate->year,
            'day' => $carbonDate->day,
            'lastDayOfMonth' => $carbonDate->endOfMonth()->day,
        ];
    }
}
