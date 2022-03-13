<?php

namespace App\Services;

use Carbon\Carbon;
use App\Models\User;
use Carbon\CarbonInterface;
use App\Models\ExpenseReport;
use App\Enums\Fee\FeeTypeEnum;
use App\Enums\ExpenseReport\ReportStateEnum;

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
            ['amount' => 0, 'type_id' => FeeTypeEnum::Step],
            ['amount' => 0, 'type_id' => FeeTypeEnum::KilometersFee],
            ['amount' => 0, 'type_id' => FeeTypeEnum::NightHotel],
            ['amount' => 0, 'type_id' => FeeTypeEnum::RestaurantMeal]
        ]);
    }
}
