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
        Schema::create('message_transactions', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('credit')->default(0);
            $table->integer('debit')->default(0);
            $table->integer('balance')->default(0)->nullable();
            $table->string('remark')->nullable();
            $table->timestamps();

            //foreign key
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('message_transactions');
    }
};
