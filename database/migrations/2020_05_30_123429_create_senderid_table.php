<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSenderidTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('senderid', function (Blueprint $table) {
            $table->id();
            $table->uuid('uid');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('currency_id')->nullable();
            $table->string('sender_id');
            $table->enum('status', ['pending', 'active', 'block', 'payment_required', 'expired'])->default('pending');
            $table->string('price', 50)->default(0);
            $table->string('billing_cycle',50);
            $table->integer('frequency_amount');
            $table->string('frequency_unit',5);
            $table->date('validity_date')->nullable();
            $table->string('transaction_id')->nullable();
            $table->boolean('payment_claimed')->default(false);
            $table->timestamps();
            $table->text('description')->nullable();
            $table->string('entity_id')->nullable();
            $table->text('document')->nullable();

            // foreign
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('currency_id')->references('id')->on('currencies')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('senderid');
    }
}
