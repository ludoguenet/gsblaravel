<?php

declare(strict_types = 1);

namespace App\Charts;

use Chartisan\PHP\Chartisan;
use Illuminate\Http\Request;
use App\Models\ExpenseReport;
use ConsoleTVs\Charts\BaseChart;

class ExpenseChart extends BaseChart
{
    /**
     * Handles the HTTP request for the given chart.
     * It must always return an instance of Chartisan
     * and never a string or an array.
     */
    public function handler(Request $request): Chartisan
    {
        [$expenseReportDates, $expenseReportFeesTotal] = $this->getData();

        return Chartisan::build()
            ->labels($expenseReportDates)
            ->dataset('Totaux', $expenseReportFeesTotal);
    }

    private function getData(): array
    {
        $expenseReportDates = auth()->user()->expenseReports()->orderBy('created_at')->pluck('created_at')->map(function ($expenseReportDate) {
            return $expenseReportDate->format('d/m/Y');
        })->all();

        $expenseReportTotals = auth()->user()->expenseReports->map(function ($report) {
            $report->loadSum(['extraFees' => function ($query) {
                return $query->whereExists(function ($query) {
                    $query->select('id')
                        ->from('proofs')
                        ->whereColumn('proofs.extra_fee_id', 'extra_fees.id');
                });
            }], 'amount');

            return $report->fees_total + $report->extra_fees_sum_amount;
         })->all();

         return [$expenseReportDates, $expenseReportTotals];
    }
}