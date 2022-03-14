<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreExpenseReportRequest;
use App\Models\ExpenseReport;
use App\Models\ExtraFee;
use Illuminate\Http\Request;

class ExpenseReportExtraFeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(ExpenseReport $expenseReport)
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(ExpenseReport $expenseReport)
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreExpenseReportRequest $request, ExpenseReport $expenseReport)
    {
        $expenseReport->fees->map(fn ($fee) => $fee->update(['quantity' => $request->fees[$fee->type->id]]));

        if ($request->filled(['label', 'created_at', 'amount'])) {
            $expenseReport->extraFees()->create($request->only('label', 'created_at', 'amount'));
        }

        return to_route('report.create')->with('success', 'Les frais ont bien été mis à jour.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(ExpenseReport $expenseReport, ExtraFee $extraFee)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(ExpenseReport $expenseReport, ExtraFee $extraFee)
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
    public function update(Request $request, ExpenseReport $expenseReport, ExtraFee $extraFee)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(ExpenseReport $expenseReport, ExtraFee $extraFee)
    {
        $extraFee->delete();

        return redirect()->back()->with('success', 'Le frais hors forfait a bien été supprimé.');
    }
}
