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
        Schema::create('society_members', function (Blueprint $table) {
            $table->id();            
            $table->integer('society_id');
            $table->integer('member_id');
            $table->dateTime('start_date', $precision = 0)->nullable(); 
            $table->dateTime('end_date', $precision = 0)->nullable(); 
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
        Schema::dropIfExists('society_members');
    }
};
