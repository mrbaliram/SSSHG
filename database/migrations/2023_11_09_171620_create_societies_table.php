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
        Schema::create('societies', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('code')->nullable();
            $table->decimal('contribution_amount')->nullable();
            $table->decimal('maximum_loan_amount')->nullable();
            $table->decimal('intrest_rate')->default('1');
            $table->string('branch_code')->nullable();            
            $table->dateTime('start_date', $precision = 0)->nullable(); 
            $table->string('contact_person')->nullable();
            $table->string('contact_no')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('address1')->nullable();
            $table->string('address2')->nullable();
            $table->string('pin_code')->nullable();
            $table->boolean('status')->nullable();
            $table->string('remarks')->nullable();
            $table->string('other_info1')->nullable();
            $table->string('other_info2')->nullable();
            $table->string('logo_url')->nullable();
            $table->string('image_url')->nullable();
            $table->boolean('is_delete')->nullable();

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
        Schema::dropIfExists('societies');
    }
};
