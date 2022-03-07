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
        Schema::create('out_package_expense_form_lines', function (Blueprint $table) {
            $table->id();
            $table->string('label');
            $table->integer('amount');

            // Foreign Expense Form Key
            $table->unsignedBigInteger('expense_form_id');
            $table->foreign('expense_form_id')->references('id')
                ->on('expense_forms')
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
        Schema::dropIfExists('out_package_expense_form_lines');
    }
};
