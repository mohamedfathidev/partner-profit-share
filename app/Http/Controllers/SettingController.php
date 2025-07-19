<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $settings = Setting::all();
        return view('settings.index', compact('settings'));
    }

    public function load()
    {
        $records = Setting::select('id', 'key', 'value');

        return datatables()
        ->of($records)
        ->addColumn('actions', function ($row) {

            $buttons = "";

            $buttons .="<a href='/dashboard/partners/$row->id/edit' class='btn btn-sm btn-warning' style='margin-left:5px;'>تعديل</a>";

            return $buttons;
        })
        ->rawColumns(['actions'])
        ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Setting $setting)
    {

        $details = $setting;
        return view('settings.edit', compact('details'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Setting $setting): RedirectResponse
    {
        $request->validate([
            "value" => 'required',
        ]);

        $setting->update([
            "value" => $request->value,
        ]);

        return redirect()->route('settings.index')->with('success', 'تم تحديث الإعداد بالنجاح');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
