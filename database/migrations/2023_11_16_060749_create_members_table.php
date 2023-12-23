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
        Schema::create('members', function (Blueprint $table) {
            $table->id();
            $table->integer('member_type_id');
            $table->integer('user_id');
            $table->integer('parent_id')->nullable();
            $table->integer('reference_id')->nullable();
            $table->integer('sub_reference_id')->nullable();
            $table->string('name')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('address1')->nullable();
            $table->string('address2')->nullable();
            $table->string('pin_code')->nullable();
            $table->string('guardian')->nullable();
            $table->string('gender')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('password')->nullable();
            $table->string('other_info')->nullable();
            $table->string('other_info2')->nullable();
            $table->string('adhar_card_url')->nullable();
            $table->string('photo_url')->nullable();
            $table->mediumText('remarks')->nullable();
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
        Schema::dropIfExists('members');
    }
};
