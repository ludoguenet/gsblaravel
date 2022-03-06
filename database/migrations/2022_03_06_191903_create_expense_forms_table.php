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
        Schema::create('expense_forms', function (Blueprint $table) {
            $table->id();

            // Foreign User Key
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');

            // Foreign Expense Form State Key
            $table->unsignedBigInteger('expense_form_state_id');
            $table->foreign('expense_form_state_id')->references('id')->on('expense_form_states');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('expense_forms');
    }
};
