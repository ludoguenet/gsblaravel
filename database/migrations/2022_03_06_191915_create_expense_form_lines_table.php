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
        Schema::create('expense_form_lines', function (Blueprint $table) {
            $table->id();
            $table->integer('amount');

            // Foreign Expense Form Key
            $table->unsignedBigInteger('expense_form_id');
            $table->foreign('expense_form_id')->references('id')->on('expense_forms');

            // Foreign Expense Fee Type Key
            $table->unsignedBigInteger('expense_fee_type_id');
            $table->foreign('expense_fee_type_id')->references('id')->on('expense_fee_types');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('expense_form_lines');
    }
};
