<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\ExpenseForm;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ExpenseReport;
use App\Services\ExpenseReportService;
use Illuminate\Database\Eloquent\Builder;

class ExpenseReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(ExpenseReportService $service)
    {
        $expenseReport = request()->whenHas('expenseReportMonth', function ($expenseReportDate) use ($service) {
            $expenseReport = $service->getFromMonth(
                auth()->user(),
                Carbon::parse($expenseReportDate)
            );

            return $expenseReport;
        }, function () {
            return $expenseReport = null;
        });

        $expenseReportMonths = ExpenseReport::all()->pluck('created_at');

        return view('expense_reports.index', compact('expenseReportMonths', 'expenseReport'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(ExpenseReportService $service)
    {
        $expenseReport = $service->getOrCreate(auth()->user());

        return view('expense_reports.create', compact('expenseReport'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ExpenseReport $report)
    {
        $report->fees->map(fn ($fee) => $fee->update(['amount' => $request->fees[$fee->type->id]]));

        return to_route('report.create')->with('success', 'Frais forfaitisés mis à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
