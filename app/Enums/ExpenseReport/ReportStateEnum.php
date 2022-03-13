<?php

namespace App\Enums\ExpenseReport;

enum ReportStateEnum: int
{
    case Closed = 1;
    case InProcess = 2;
    case Refunded = 3;
    case Validated = 4;
}
