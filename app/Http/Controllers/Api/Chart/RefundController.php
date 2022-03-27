<?php

namespace App\Http\Controllers\Api\Chart;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;

class RefundController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(): JsonResponse
    {
        $expenseReportDates = auth()->user()->expenseReports()
            ->whereYear('created_at', Carbon::now()->year)
            ->orderBy('created_at')
            ->pluck('created_at')
            ->map(function ($expenseReportDate) {
            return $expenseReportDate->translatedFormat('M');
        });

        $expenseReportTotals = auth()->user()->expenseReports()
            ->whereYear('created_at', Carbon::now()->year)
            ->orderBy('created_at')
            ->get()
            ->map(function ($report) {
                $report->loadSum(['extraFees' => function ($query) {
                    return $query->has('proof');
                }], 'amount');

                return ($report->fees_total + $report->extra_fees_sum_amount) / 100;
            });

        return response()->json([
            'expenseReportDates' => $expenseReportDates,
            'expenseReportTotals' => $expenseReportTotals,
            'current_year' => Carbon::now()->year
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
