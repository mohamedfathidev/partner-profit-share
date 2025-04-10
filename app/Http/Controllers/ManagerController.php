<?php

namespace App\Http\Controllers;

use App\Models\Manager;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ManagerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        return view('managers.index');
    }

    public function load()
    {
        $records = Manager::query();

        return datatables()
            ->of($records)
            ->editColumn('created_at', function ($row) {
                return Carbon::parse($row->created_at)->format('Y-m-d');
            })
            ->editColumn('percentage', function ($row) {
                return $row->percentage. "%";
            })
            ->editColumn('active', function ($row) {
                if($row->active){
                    return "<span class='badge badge-success'>نشط</span>";
                }
                else{
                    return "<span class='badge badge-danger'>غير نشط</span>";
                }
            })
            ->addColumn('actions', function ($row) {
                $buttons = "";

                $buttons .="<a href='/dashboard/managers/{$row->id}/edit' class='btn btn-sm btn-warning' style='margin-left: 5px;'>تعديل</a>";
                $buttons .="<a href='javascript:void(0);' data-url='/dashboard/managers/$row->id' class='delete-record btn btn-sm btn-danger'>حذف</a>";

                return $buttons;
            })
            ->rawColumns(['actions', 'active'])
            ->make(true);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('managers.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            "name" => "required",
            "percentage" => "required|numeric",
        ],[
            "name.required" => 'هذا الحقل مطلوب',
            "percentage.required" => 'هذا الحقل مطلوب',
            "percentage.numeric" => 'يجب أدخال أرقام',
        ]);

        Manager::create([
            "name" => $request->get("name"),
            "percentage" => $request->get("percentage"),
            "active" => $request->get("active") ?? 0,
        ]);

        return redirect()->route('managers.index')
            ->with('success', 'تم إضافة مدير بنجاح');
    }

    /**
     * Display the specified resource.
     */
    public function show(Manager $manager)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Manager $manager)
    {
        $details  = $manager;
        return view('managers.edit', compact('details'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $id)
    {
        $request->validate([
            "name" => "required",
            "percentage" => "required|numeric",
        ],[
            "name.required" => 'هذا الحقل مطلوب',
            "percentage.required" => 'هذا الحقل مطلوب',
            "percentage.numeric" => 'يجب أدخال أرقام',
        ]);

        Manager::find($id)->update([
            "name" => $request->get("name"),
            "percentage" => $request->get("percentage"),
            "active" => $request->get("active") ?? 0,
        ]);

        return redirect()->route('managers.index')
            ->with('success', 'تم تحديث بيانات المدير بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Manager $manager)
    {
        $manager->delete();

        // important to return json if you faced an error for reloading the table
        return response()->json(['message' => 'تم حذف المدير بنجاح'], 200);
    }
}
