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
        Schema::create('api_details', function (Blueprint $table) {
            $table->id();
            $table->string('username', 100);
            $table->string('password', 100);
            $table->string('sendername', 10);
            $table->integer('routetype')->default(true);
            $table->integer('user_id')->nullable();
            $table->timestamps();

            // foreign
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
        Schema::dropIfExists('api_details');
    }
};
