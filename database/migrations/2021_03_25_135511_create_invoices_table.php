<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->uuid('uid');
            $table->string('invoice_number', 50)->nullable();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('currency_id');
            $table->unsignedBigInteger('payment_method');
            $table->string('amount');
            $table->double('connection_addons_price', 16, 2)->default(0.00);
            $table->integer('duration_count')->default(0);
            $table->decimal('adjusted_plan_price', 16, 2)->default(0.00);
            $table->decimal('adjusted_addons_price', 16, 2)->default(0.00);
            $table->string('type');
            $table->text('description')->nullable();
            $table->string('transaction_id')->nullable();
            $table->string('status')->nullable();
            $table->integer('is_renew')->default(0);
            $table->integer('addons_connections')->default(0);
            $table->timestamps();

            //foreign key
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('currency_id')->references('id')->on('currencies')->onDelete('cascade');
            $table->foreign('payment_method')->references('id')->on('payment_methods')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('invoices');
    }
}
