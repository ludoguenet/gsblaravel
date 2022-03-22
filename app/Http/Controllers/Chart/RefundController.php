<?php

namespace App\Http\Controllers\Chart;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RefundController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(): JsonResponse
    {
        $expenseReportDates = auth()->user()->expenseReports()->orderBy('created_at')->pluck('created_at')->map(function ($expenseReportDate) {
            return $expenseReportDate->translatedFormat('M');
        });

        $expenseReportTotals = auth()->user()->expenseReports()
            ->orderBy('created_at')
            ->get()
            ->map(function ($report) {
                $report->loadSum(['extraFees' => function ($query) {
                    return $query->whereExists(function ($query) {
                        $query->select('id')
                            ->from('proofs')
                            ->whereColumn('proofs.extra_fee_id', 'extra_fees.id');
                    });
                }], 'amount');

                return ($report->fees_total + $report->extra_fees_sum_amount) / 100;
            });

        return response()->json([
            'expenseReportDates' => $expenseReportDates,
            'expenseReportTotals' => $expenseReportTotals
        ]);
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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
