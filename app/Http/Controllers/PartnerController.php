<?php

namespace App\Http\Controllers;

use App\Models\ProfitShare;
use Carbon\Carbon;
use App\Models\Partner;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\StorePartnerRquest;
use App\Http\Requests\UpdatePartnerRequest;
use niklasravnsborg\LaravelPdf\Facades\Pdf;


class PartnerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        return view('partners.index');
    }

    public function load(): JsonResponse
    {
        $records = Partner::select('id','name', 'initial_balance', 'active', 'created_at');

        return datatables()
        ->of($records)
        ->editColumn('created_at', function ($row) {
            return Carbon::parse($row->created_at)->locale('ar')->translatedFormat("j F Y، l");
        })
        ->editColumn('name', function ($row) {
            return "<a href='" . route('partners.show', $row->id) . "' class='text-primary'>$row->name</a>";
        })
        ->editColumn('active', function ($row) {
            if($row->active){
                return "<span class='badge badge-success'>نشط</span>";
            }
            else{
                return "<span class='badge badge-danger'>غير نشط</span>";
            }
        })
        ->addColumn('balance', function ($row) {
            return $row->balance;
        })
        ->addColumn('actions', function ($row) {
            $buttons = "";

            $buttons .="<a href='/dashboard/partners/$row->id/edit' class='btn btn-sm btn-warning' style='margin-left:5px;'>تعديل</a>";
            $buttons .= "<a href='javascript:void(0);' data-url='/dashboard/partners/$row->id' data-table='partners-table' class='delete-record btn btn-sm btn-danger'>حذف</a>";

            return $buttons;
        })
        ->rawColumns(['actions', 'name', 'active'])
        ->make(true);
    }
    
    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('partners.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePartnerRquest $request)
    {
        Partner::create([
            "name" => $request->name,
            "initial_balance" => $request->initial_balance,
            "address" => $request->address,
            "phone" => $request->phone,
            "active" => $request->active ?? 0,
        ]);

        return redirect()->route('partners.index')->with('success', 'تم إضافة شريك جديد');
    }

    /**
     * Display the specified resource.
     */
    public function show(Partner $partner)
    {
        $partnerTransactions = $partner->load(['transactions']);

        $partnerProfits = $partner->load('profitShares');

        return view('partners.show', compact('partner', 'partnerTransactions', 'partnerProfits'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $id)
    {
        $details = Partner::find($id);

        return view('partners.edit', compact('details'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePartnerRequest $request, Partner $partner)
    {
        $partnerNew = $partner->update([
            "name" => $request->name,
            "phone" => $request->phone,
            "initial_balance" => $request->initial_balance,
            "address" => $request->address,
            "active" => $request->active ?? 0,
        ]);

        return redirect()->route('partners.index')
            ->with('success', 'تم تحديث بيانات الشريك');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Partner $partner)
    {
        $partner->profitShares()->delete();
        $partner->transactions()->delete();
        $partner->delete();

        return response()->json(['message' => 'تم حذف الشريك بنجاح'], 200);
    }
}
