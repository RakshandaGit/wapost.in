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
        Schema::create('authors', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255);
            $table->string('email', 255)->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->string('profile_pic', 255)->nullable();
            $table->string('designation', 255)->nullable();
            $table->string('bio', 600)->nullable();
            $table->text('facebook_profile')->nullable();
            $table->string('instagram_profile', 255)->nullable();
            $table->string('linkedin_profile', 255)->nullable();
            $table->integer('status')->default(1)->comment('0 - Deactivate, 1 - Active, 2 - Suspended');
            $table->timestamps();
        
            // foreign
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
        });
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('authors');
    }
};
