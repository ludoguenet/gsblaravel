<?php

namespace Tests\Feature\ExpenseReport;

use Carbon\Carbon;
use Tests\TestCase;
use App\Models\User;
use App\Models\ExpenseReport;
use App\Services\ExpenseReportService;
use App\Enums\ExpenseReport\ReportStateEnum;
use App\Models\State;
use Database\Factories\StateFactory;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ExpenseReportTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_user_have_empty_expense_report_attached_if_get_report_first_time()
    {
        $user = User::factory()->create();
        State::factory()->create(['id' => ReportStateEnum::InProcess->value]);

        $this->assertDatabaseCount('expense_reports', 0);

        $this->actingAs($user)->get('report/create');
        $expenseReport = ExpenseReport::first();

        $this->assertDatabaseCount('expense_reports', 1);
        $this->assertEquals($expenseReport->user_id, $user->id);
        $this->assertEquals($expenseReport->state_id, ReportStateEnum::InProcess->value);
    }

    public function test_user_have_current_month_when_get_report_first_time()
    {
        $user = User::factory()->create();
        State::factory()->create(['id' => ReportStateEnum::InProcess->value]);

        $this->actingAs($user)->get('report/create');
        $expenseReport = ExpenseReport::first();

        $this->assertEquals(Carbon::now()->format('F'), $expenseReport->created_at->format('F'));
    }
}
