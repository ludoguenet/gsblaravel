<?php

namespace App\Services;

use Carbon\Carbon;
use App\Models\User;
use Carbon\CarbonInterface;
use App\Models\ExpenseReport;
use App\Enums\Fee\FeeTypeEnum;
use App\Enums\ExpenseReport\ReportStateEnum;
use App\Models\ExtraFee;

class ExpenseReportService
{
    public function getOrCreate(User $authedUser): ExpenseReport
    {
        $expenseReport = $this->getCurrentMonthReport($authedUser);

        if (!$expenseReport) {
            $expenseReport = $this->createExpenseReport($authedUser);
        }

        return $expenseReport;
    }

    public function getFromMonth(User $authedUser, CarbonInterface $expenseReportDate): ExpenseReport|null
    {
        $expenseReport = $this->getCurrentMonthReport($authedUser, $expenseReportDate);

        if ($expenseReport) {
            $this->loadSum($expenseReport);
            $this->calculateTotalOfTotals($expenseReport);
        }
            
        return $expenseReport;
    }

    private function getCurrentMonthReport(User $authedUser, CarbonInterface $expenseReportDate = null): ExpenseReport|null
    {
        return ExpenseReport::whereBelongsTo($authedUser)
            ->whereMonth('created_at', $expenseReportDate ?: Carbon::now()->month)
            ->whereYear('created_at', $expenseReportDate ?: Carbon::now()->year)
            ->first();
    }

    private function createExpenseReport(User $authedUser): ExpenseReport
    {
        $expenseReport = $authedUser->expenseReports()->create([
            'state_id' => ReportStateEnum::InProcess->value
        ]);

        $this->createReportFees($expenseReport);

        return $expenseReport;
    }

    private function createReportFees(ExpenseReport $expenseReport): void
    {
        $expenseReport->fees()->createMany([
            ['quantity' => 0, 'type_id' => FeeTypeEnum::Step],
            ['quantity' => 0, 'type_id' => FeeTypeEnum::KilometersFee],
            ['quantity' => 0, 'type_id' => FeeTypeEnum::NightHotel],
            ['quantity' => 0, 'type_id' => FeeTypeEnum::RestaurantMeal]
        ]);
    }

    private function loadSum(ExpenseReport $expenseReport): void
    {
        // $expenseReport->addSelect([
        //     'total_extra_fees' => ExtraFee::whereColumn('expense_report_id', 'expense_reports.id')
        //         ->selectRaw('SUM(extra_fees.amount)')
        //         ->has('proof')
        // ]);

        // dd($expenseReport);
        
        $expenseReport->loadSum(['extraFees' => function ($query) {
            return $query->has('proof');
        }], 'amount');
    }

    private function calculateTotalOfTotals(ExpenseReport $expenseReport): void
    {
        $expenseReport->totalOfTotals = $expenseReport->fees_total + $expenseReport->extra_fees_sum_amount;
    }
}
