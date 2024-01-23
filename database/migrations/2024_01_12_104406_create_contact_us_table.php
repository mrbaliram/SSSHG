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
        Schema::create('contact_us', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('society_member_id');
            $table->string('account_number')->nullable();
            $table->string('name')->nullable();
            $table->string('mobile')->nullable();
            $table->string('type')->nullable();
            $table->mediumText('message')->nullable();
            $table->mediumText('remarks')->nullable();
            $table->string('other_info1')->nullable();
            $table->string('other_info2')->nullable();
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
        Schema::dropIfExists('contact_us');
    }
};
