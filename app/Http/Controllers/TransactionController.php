<?php

namespace App\Http\Controllers;

use App\Models\MonthProfit;
use App\Services\CheckMonthClosedService;
use Carbon\Carbon;
use App\Models\Partner;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\StoreTransactionRquest;
use App\Http\Requests\UpadteTransactionRquest;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        return view('transactions.index');
    }

    /**
     * load data in Json
     */
    public function load(Request $request): JsonResponse
    {
        $records = Transaction::with('partner')->select('id', 'partner_id', 'amount', 'date', 'type', 'note', 'created_at');

        if($request->filled('from_date') && $request->filled('to_date'))
        {
            $records->whereBetween('date', [$request->from_date, $request->to_date]);
        }

        return datatables()
        ->of($records)
        ->editColumn('date', function ($row) {
            return Carbon::parse($row->date)->locale('ar')->translatedFormat('F Y');
        })
        ->editColumn('type', function ($row) {
            if ($row->type == 'deposite')
            {
                return "<p class='text-bold text-success' style='font-size:18px; font-weight: bold;'>إيداع</p>";
            }
            else {
                return "<p class='text-bold text-danger' style='font-size:18px; font-weight: bold;'>سحب</p>";
            }
        })
        ->addColumn('partner', function ($row) {
            return $row->partner?->name;
        })
        ->addColumn('actions', function ($row) {
            $buttons = "";

            $buttons .="<a href='/dashboard/transactions/$row->id/edit' class='btn btn-sm btn-warning' style='margin-left:5px;'>تعديل</a>";
            $buttons .="<a href='javascript:void(0);' data-url='/dashboard/transactions/$row->id' class='delete-record btn btn-sm btn-danger'>حذف</a>";

            return $buttons;
        })
        ->rawColumns(['actions', 'type'])
        ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $partners = Partner::pluck('name', 'id')->toArray();

        return view('transactions.create', compact('partners'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTransactionRquest $request, CheckMonthClosedService $checkMonthIsClosed): RedirectResponse
    {
        $existedDistributedMonth = $checkMonthIsClosed->monthIsClosed(Carbon::parse($request->get('date')));
        if($existedDistributedMonth)
        {
            return redirect()->back()->with('error', 'لا يمكن إدخال معاملات لشهر تم توزيع أرباحه');
        }

        Transaction::create([
            "partner_id" => $request->partner_id,
            "type" => $request->type,
            "amount" => $request->amount,
            "date" => $request->date,
            "note" => $request->note,
        ]);

        return redirect()->route('transactions.index')->with('success', 'تم إضافة معاملة بنجاح');
    }

    /**
     * Display the specified resource.
     */
    public function show(Transaction $transaction)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Transaction $transaction): View
    {
        $details = $transaction;

        $partners = Partner::pluck('name', 'id')->toArray();

        return view('transactions.edit', compact('details', 'partners'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpadteTransactionRquest $request, Transaction $transaction, CheckMonthClosedService $checkMonthIsClosed): RedirectResponse
    {
        $existedDistributedMonth = $checkMonthIsClosed->monthIsClosed(Carbon::parse($request->get('date')));
        if($existedDistributedMonth)
        {
            return redirect()->back()->with('error', 'لا يمكن تعديل معاملات شهر تم توزيع أرباحه');
        }

        $transaction->update([
            "partner_id" => $request->partner_id,
            "type" => $request->type,
            "amount" => $request->amount,
            "date" => $request->date,
            "note" => $request->note,
        ]);

        return redirect()->route('transactions.index')
            ->with('success', 'تم تحديث بيانات المعاملة بنجاح');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Transaction $transaction): JsonResponse
    {
        $transaction->delete();

        return response()->json(['message' => 'تم حذف المعاملة بنجاح'], 200);
    }

}
