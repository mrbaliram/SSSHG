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
        Schema::create('contribution_payments', function (Blueprint $table) {
            $table->id();
            $table->integer('society_member_id');
            $table->decimal('amount')->nullable(); 
            $table->decimal('late_fine')->nullable(); 
            $table->dateTime('pay_date', $precision = 0)->nullable(); 
            $table->string('pay_for_month_year')->nullable(); 
            $table->tinyInteger('status')->default('1');
            $table->tinyInteger('is_delete')->default('0');
            $table->string('other_info')->nullable();
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
        Schema::dropIfExists('contribution_payments');
    }
};
