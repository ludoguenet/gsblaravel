<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('extra_fees', function (Blueprint $table) {
            $table->id();
            $table->string('label');
            $table->integer('amount');
            $table->dateTime('created_at');

            // Foreign Expense Report Key
            $table->unsignedBigInteger('expense_report_id');
            $table->foreign('expense_report_id')->references('id')
                ->on('expense_reports')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('extra_fees');
    }
};
