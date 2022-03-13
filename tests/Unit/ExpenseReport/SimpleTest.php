<?php

namespace Tests\Unit\ExpenseReport;

use Carbon\Carbon;
use Tests\TestCase;
use App\Models\User;
use App\Models\State;
use App\Models\ExpenseReport;
use App\Enums\ExpenseReport\ReportStateEnum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ExpenseReportClass extends TestCase
{
    use RefreshDatabase;
    public function test_expense_report_can_be_retrieved_for_actual_month()
    {
        $user = User::factory()->create();
        $state = State::factory()->create(['id' => ReportStateEnum::InProcess->value]);

        $expenseReport = ExpenseReport::factory([
            'state_id' => $state->id,
            'user_id' => $user->id
        ])->create();

        $currentExpenseReport = ExpenseReport::whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->first();

        $this->assertEquals($expenseReport->id, $currentExpenseReport->id);
    }
}
