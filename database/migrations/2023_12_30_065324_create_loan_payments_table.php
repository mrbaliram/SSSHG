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
        Schema::create('loan_payments', function (Blueprint $table) {
            $table->id();
            $table->integer('loan_account_id');
            $table->decimal('paid_amount')->nullable(); 
            $table->decimal('intrest_amount')->nullable(); 
            $table->decimal('balance')->nullable();
            $table->dateTime('pay_date', $precision = 0)->nullable();
            $table->string('other_info')->nullable();
            $table->string('remarks')->nullable();
            $table->tinyInteger('status')->default('1');
            $table->tinyInteger('is_delete')->default('0');
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
        Schema::dropIfExists('loan_payments');
    }
};
